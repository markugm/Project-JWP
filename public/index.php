<?php
// public/index.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/function.php'; // Asumsi function e() ada di sini

// --- 1. LOGIC PHP UNTUK ARTIKEL TERBARU ---
$latestArticles = [];
try {
    // Query untuk mengambil 3 artikel terbaru, diurutkan berdasarkan created_at, dan join dengan tabel users
    $sql = "SELECT 
                a.title, a.slug, a.content, a.created_at, a.featured_image,
                u.name AS author_name, u.role AS author_role
            FROM articles a
            LEFT JOIN users u ON a.author_id = u.id
            ORDER BY a.created_at DESC
            LIMIT 3";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $latestArticles = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
    }
} catch (Exception $e) {
    // Handle error koneksi atau query jika perlu, tapi biarkan array $latestArticles kosong
    error_log("Database error on homepage: " . $e->getMessage());
}

/**
 * Helper function untuk mendapatkan inisial dari nama
 * @param string $name Nama lengkap
 * @return string Inisial (maksimal 2 huruf)
 */
function get_initials($name)
{
    $parts = explode(' ', trim($name));
    $initials = '';
    if (!empty($parts)) {
        $initials .= strtoupper(substr($parts[0], 0, 1));
        if (count($parts) > 1) {
            $initials .= strtoupper(substr(end($parts), 0, 1));
        }
    }
    return $initials;
}

?>

<?php include __DIR__ . '/_header.php'; ?>

<main>
    <style>
        /* Essential CSS for the Sticky Footer */
        /* Dipindahkan ke sini untuk memastikan styling diterapkan dengan benar */
        body {
            /* 1. Make the body a flex container */
            display: flex;
            /* 2. Stack the children vertically */
            flex-direction: column;
            /* 3. Ensure the body takes up at least the full height of the viewport */
            min-height: 100vh;
            /* Optional: Remove default margin */
            margin: 0;
        }

        /* 4. Tell the main content area to take up all remaining space */
        main {
            flex-grow: 1;
        }
    </style>


    <!-- HERO SECTION: Padding Vertikal Dikecilkan -->
    <section class="pb-10 pt-12 md:pt-16 bg-gray-50 border-b border-gray-200">
        <div class="relative isolate lg:px-8">
            <!-- Padding Vertikal Dikecilkan: py-10 md:py-16 -->
            <div class="mx-auto max-w-4xl py-10 md:py-16">
                <div class="text-center">
                    <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-7xl">
                        Eksplorasi Dunia <span class="text-indigo-600">Teknologi</span> dan <span class="text-purple-700">Inovasi</span>
                    </h1>
                    <p class="mt-8 text-xl text-pretty text-gray-600 max-w-3xl mx-auto">
                        Lapak Kita adalah sumber terpercaya Anda untuk artikel mendalam, tutorial, dan berita terbaru seputar pengembangan web, bisnis digital, dan tren industri.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="contact.php" class="rounded-lg bg-indigo-600 px-4 py-3 text-base font-semibold text-white shadow-xl hover:bg-indigo-700 transition duration-150">
                            Kontak
                        </a>
                        <a href="about.php" class="text-base font-semibold text-gray-700 hover:text-indigo-600 transition">
                            Tentang Kami <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ARTICLE SECTION: Dibuat Dinamis -->
    <section class="mb-12 pt-16 pb-10">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <!-- Header Artikel Terbaru (Side by Side) -->
            <div class="mx-auto max-w-full lg:mx-0 flex justify-between items-center pb-6">
                <h2 class="text-3xl font-bold text-gray-800">Artikel Terbaru</h2>
                <a href="articles.php" class="text-purple-700 hover:underline text-base font-semibold shrink-0 flex items-center gap-1">
                    Lihat Semua Artikel
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <?php if (empty($latestArticles)): ?>
                <div class="text-center py-16 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                    <p class="text-lg font-medium">Belum ada artikel yang tersedia saat ini.</p>
                </div>
            <?php else: ?>
                <!-- Grid Artikel Dinamis -->
                <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 lg:mx-0 lg:max-w-none lg:grid-cols-3">

                    <?php foreach ($latestArticles as $article):
                        // Link ke halaman artikel, asumsi formatnya articles.php?slug=SLUG
                        $articleUrl = 'articles.php?slug=' . e($article['slug']);
                        // Mengambil deskripsi singkat (jika konten terlalu panjang)
                        $summary = strip_tags($article['content']);
                        $summary = mb_substr($summary, 0, 150) . (mb_strlen($summary) > 150 ? '...' : '');

                        // Mendapatkan Inisial Penulis
                        $initials = get_initials($article['author_name'] ?? 'U A');

                        // Menentukan warna latar belakang inisial (bisa acak atau berdasarkan role)
                        $bgColor = $article['author_role'] === 'admin' ? 'bg-indigo-500' : 'bg-gray-700';
                        $roleText = $article['author_role'] === 'admin' ? 'Admin' : 'Penulis';

                    ?>
                        <article class="flex max-w-xl flex-col justify-between p-4 bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">

                            <!-- Thumbnail Gambar -->
                            <?php if ($article['featured_image']): ?>
                                <a href="<?= $articleUrl ?>" class="block mb-4">
                                    <!-- FIX: Mengoreksi path gambar untuk tampilan di frontend -->
                                    <img src="<?= e($article['featured_image']) ?>" onerror="this.onerror=null;this.src='https://placehold.co/600x300/e0e0e0/555?text=Lapak+Kita';" alt="<?= e($article['title']) ?>" class="w-full h-48 object-cover rounded-lg shadow-md">
                                </a>
                            <?php endif; ?>

                            <!-- Metadata -->
                            <div class="flex items-center gap-x-4 text-xs">
                                <time datetime="<?= date('Y-m-d', strtotime($article['created_at'])) ?>" class="text-gray-500">
                                    <?= date('d M Y', strtotime($article['created_at'])) ?>
                                </time>
                            </div>

                            <!-- Judul & Ringkasan -->
                            <div class="group relative grow mt-2">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition duration-150">
                                    <a href="<?= $articleUrl ?>">
                                        <span class="absolute inset-0"></span>
                                        <?= e($article['title']) ?>
                                    </a>
                                </h3>
                                <p class="mt-3 line-clamp-3 text-sm text-gray-600">
                                    <?= e($summary) ?>
                                </p>
                            </div>

                            <!-- Info Penulis (Menggunakan Inisial) -->
                            <div class="relative mt-6 flex items-center gap-x-4 pt-4 border-t border-gray-100">
                                <!-- Kontainer Inisial -->
                                <div class="size-10 rounded-full flex items-center justify-center text-white font-bold text-sm <?= $bgColor ?> shrink-0 shadow-md">
                                    <?= $initials ?>
                                </div>

                                <div class="text-sm">
                                    <p class="font-semibold text-gray-900">
                                        <a href="#" class="hover:text-indigo-600">
                                            <?= e($article['author_name'] ?? 'Unknown Author') ?>
                                        </a>
                                    </p>
                                    <p class="text-gray-500 text-xs mt-0.5">Role: <?= $roleText ?></p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CALL TO ACTION / Social -->
    <section class="mb-16">
        <div class="mx-auto max-w-6xl px-6 lg:px-8 bg-gray-50 rounded-lg shadow-md p-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Tetap Terhubung</h3>
                <p class="text-sm text-gray-600 mt-1">Ikuti update artikel dan pengumuman terbaru—boleh juga kirimkan pertanyaan lewat kontak.</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Instagram -->
                <a href="https://instagram.com/yourhandle" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full  from-pink-500 to-yellow-400 shadow hover:scale-110 transition-transform" aria-label="Instagram">
                    <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram" class="w-5 h-5">
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full  shadow hover:scale-110 transition-transform" aria-label="WhatsApp">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" class="w-5 h-5">
                </a>

                <!-- Twitter -->
                <a href="https://twitter.com/yourhandle" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full shadow hover:scale-110 transition-transform" aria-label="Twitter">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter" class="w-5 h-5">
                </a>

                <!-- Facebook -->
                <a href="https://facebook.com/yourpage" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full shadow hover:scale-110 transition-transform" aria-label="Facebook">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" class="w-5 h-5">
                </a>
            </div>
        </div>
    </section>

</main>

<?php include __DIR__ . '/_footer.php'; ?>