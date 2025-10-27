<?php
// public/admin/articles/index.php
require_once __DIR__ . '/../../../app/auth.php';
require_admin();
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../app/function.php'; // Asumsi file ini ada dan berisi function e()

// --- search + pagination setup (LET'S KEEP THE LOGIC AS IS) ---
$perPage = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $perPage;

// ambil keyword dari GET
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$whereSql = '';
$like = '';
if ($searchQuery !== '') {
    $whereSql = "WHERE (a.title LIKE ? OR a.content LIKE ?)";
    $like = '%' . $searchQuery . '%';
}

// COUNT total (dengan search)
$sqlCount = "SELECT COUNT(*) AS cnt FROM articles a $whereSql";
$stmtCount = mysqli_prepare($conn, $sqlCount);
if ($searchQuery !== '') {
    mysqli_stmt_bind_param($stmtCount, 'ss', $like, $like);
}
mysqli_stmt_execute($stmtCount);
$resCount = mysqli_stmt_get_result($stmtCount);
$row = mysqli_fetch_assoc($resCount);
$total = (int)($row['cnt'] ?? 0);
mysqli_stmt_close($stmtCount);

$totalPages = (int) ceil(max(1, $total) / $perPage);

// SELECT data (dengan search + limit)
$sql = "SELECT a.id, a.title, a.slug, a.featured_image, a.created_at, u.name AS author
        FROM articles a
        LEFT JOIN users u ON a.author_id = u.id
        $whereSql
        ORDER BY a.created_at DESC
        LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($conn, $sql);
if ($searchQuery !== '') {
    // bind: search, search, limit, offset
    mysqli_stmt_bind_param($stmt, "ssii", $like, $like, $perPage, $offset);
} else {
    mysqli_stmt_bind_param($stmt, "ii", $perPage, $offset);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// helper untuk membangun url pagination sambil mempertahankan query string lain
function admin_page_url($p) {
    $params = $_GET;
    $params['page'] = $p;
    return htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query($params));
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel | Admin Lapak Kita</title>
    <!-- Load Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for a cleaner look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb; /* Light background for the overall app */
        }
        /* Ensure the main content uses the remaining space */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        /* Styling untuk tombol aksi yang lebih modern */
        .action-icon {
            @apply w-5 h-5 p-1 rounded-full transition-colors;
        }
        .action-icon:hover {
             @apply bg-opacity-75;
        }
    </style>
</head>
<body class="admin-layout">

    <!-- 1. SIDEBAR (Kiri) -->
    <?php include __DIR__ . '/../_sidebar_admin.php'; ?>

    <!-- 2. MAIN CONTENT (Kanan) -->
    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6">
            
            <!-- HEADER KELOLA ARTIKEL -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Kelola Artikel</h1>
                <div class="text-sm text-gray-500 mt-1">Total artikel: <span class="font-medium"><?= $total ?></span></div>
            </div>

            <!-- SEARCH, RESET, DAN TOMBOL BUAT ARTIKEL (Menggunakan Flex untuk 3 Kolom Responsif) -->
            <div class="mb-6 flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <!-- Form Search -->
                <form method="GET" action="" class="flex-1 flex gap-2 w-full md:w-auto">
                    <input 
                        type="search" 
                        name="q" 
                        value="<?= htmlspecialchars($searchQuery) ?>" 
                        placeholder="Cari Judul, Isi Artikel..." 
                        class="px-4 py-2 border border-gray-300 rounded-lg w-full text-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                    />
                    <button 
                        type="submit" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md hover:bg-indigo-700 transition duration-150"
                    >
                        Search
                    </button>
                    <?php if ($searchQuery !== ''): ?>
                        <a href="index.php" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-100 flex items-center transition duration-150">Reset</a>
                    <?php endif; ?>
                </form>

                <!-- Tombol Buat Artikel di Kanan -->
                <a href="create.php" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md hover:bg-indigo-700 transition duration-150 flex-shrink-0 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Artikel
                </a>
            </div>

            <!-- TABEL ARTIKEL -->
            <?php if (count($articles) === 0): ?>
                <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg text-center text-gray-600">
                    Tidak ada artikel yang ditemukan.
                </div>
            <?php else: ?>
                <div class="rounded-lg shadow-sm overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-10">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-auto">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-24">Thumbnail</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-28">Author</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-24">Tanggal</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <?php $no = $offset + 1; foreach ($articles as $a): ?>
                                    <tr class="hover:bg-indigo-50/20 transition-colors">
                                        <td class="px-4 py-3 text-sm text-gray-600 align-middle"><?= $no++ ?></td>

                                        <td class="px-4 py-3 align-middle">
                                            <div class="font-medium text-gray-800 text-sm max-w-xs truncate" title="<?= e($a['title']) ?>"><?= e($a['title']) ?></div>
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            <?php if ($a['featured_image']): ?>
                                                <img src="<?= e('../../' . $a['featured_image']) ?>" alt="Thumbnail Artikel" class="w-16 h-10 object-cover rounded-md shadow">
                                            <?php else: ?>
                                                <div class="w-16 h-10 bg-gray-200 rounded-md flex items-center justify-center text-xs text-gray-400">No Img</div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700 align-middle"><?= e($a['author'] ?? 'Unknown') ?></td>

                                        <td class="px-4 py-3 text-sm text-gray-600 align-middle"><?= date('d M Y', strtotime($a['created_at'])) ?></td>

                                        <td class="px-4 py-3 text-center align-middle">
                                            <div class="inline-flex items-center justify-center gap-1">
                                                <!-- EDIT -->
                                                <a href="edit.php?id=<?= $a['id'] ?>" title="Edit Artikel" class="text-blue-600 action-icon hover:bg-blue-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-7-9l7 7m-7-7v7h7l-7-7z"></path></svg>
                                                </a>

                                                <!-- DELETE -->
                                                <form action="delete.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');" class="inline">
                                                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                                    <button type="submit" title="Hapus Artikel" class="text-red-600 action-icon hover:bg-red-100">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>

                                                <!-- VIEW -->
                                                <a href="<?= '../../articles.php?slug=' . e($a['slug']) ?>" target="_blank" title="Lihat Artikel di Website" class="text-gray-600 action-icon hover:bg-gray-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGINATION -->
                <?php if ($totalPages > 1): ?>
                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-6 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-600 hidden sm:block">
                            Menampilkan
                            <span class="font-semibold text-gray-800"><?= $offset + 1 ?></span> -
                            <span class="font-semibold text-gray-800"><?= min($offset + $perPage, $total) ?></span>
                            dari
                            <span class="font-semibold text-gray-800"><?= $total ?></span> artikel
                        </div>

                        <nav class="flex justify-center flex-1 sm:justify-end" aria-label="Pagination">
                            <div class="inline-flex items-center -space-x-px rounded-lg shadow-sm overflow-hidden">
                                
                                <!-- Tombol Prev -->
                                <?php if ($page > 1): ?>
                                    <a href="<?= admin_page_url($page - 1) ?>" class="relative inline-flex items-center px-3 py-2 text-gray-500 border border-gray-300 bg-white hover:bg-gray-50 text-sm font-medium transition duration-150">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M12.79 5.23a.75.75 0 0 1 0 1.06L9.07 10l3.72 3.71a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" /></svg>
                                    </a>
                                <?php else: ?>
                                    <span class="relative inline-flex items-center px-3 py-2 text-gray-300 border border-gray-200 bg-gray-50 cursor-not-allowed text-sm font-medium">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M12.79 5.23a.75.75 0 0 1 0 1.06L9.07 10l3.72 3.71a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" /></svg>
                                    </span>
                                <?php endif; ?>

                                <!-- Nomor Halaman -->
                                <?php
                                $start = max(1, $page - 2);
                                $end = min($totalPages, $page + 2);
                                if ($start > 1) {
                                    echo '<a href="' . admin_page_url(1) . '" class="px-3 py-2 text-sm text-gray-700 border border-gray-300 bg-white hover:bg-gray-50">1</a>';
                                    if ($start > 2) echo '<span class="px-3 py-2 text-sm text-gray-500 border border-gray-300 bg-white">...</span>';
                                }

                                for ($i = $start; $i <= $end; $i++):
                                    if ($i == $page):
                                ?>
                                        <span class="relative z-10 inline-flex items-center border border-indigo-600 bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition duration-150"><?= $i ?></span>
                                    <?php else: ?>
                                        <a href="<?= admin_page_url($i) ?>" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150"><?= $i ?></a>
                                    <?php endif; endfor;

                                if ($end < $totalPages) {
                                    if ($end < $totalPages - 1) echo '<span class="px-3 py-2 text-sm text-gray-500 border border-gray-300 bg-white">...</span>';
                                    echo '<a href="' . admin_page_url($totalPages) . '" class="px-3 py-2 text-sm text-gray-700 border border-gray-300 bg-white hover:bg-gray-50 transition duration-150">' . $totalPages . '</a>';
                                }
                                ?>

                                <!-- Tombol Next -->
                                <?php if ($page < $totalPages): ?>
                                    <a href="<?= admin_page_url($page + 1) ?>" class="relative inline-flex items-center px-3 py-2 text-gray-500 border border-gray-300 bg-white hover:bg-gray-50 text-sm font-medium transition duration-150">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.21 14.77a.75.75 0 0 1 0-1.06L10.93 10l-3.72-3.71a.75.75 0 1 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z" /></svg>
                                    </a>
                                <?php else: ?>
                                    <span class="relative inline-flex items-center px-3 py-2 text-gray-300 border border-gray-200 bg-gray-50 cursor-not-allowed text-sm font-medium">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M7.21 14.77a.75.75 0 0 1 0-1.06L10.93 10l-3.72-3.71a.75.75 0 1 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z" /></svg>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </nav>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </main>

    
</body>
</html>