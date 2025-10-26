<?php
// public/_header.php - Tailwind (updated: show profile dropdown when logged in)
if (session_status() === PHP_SESSION_NONE) session_start();

// safe include helper (pastikan path benar)
require_once '../app/function.php';
// require_once __DIR__ . '/app/functions.php';

$logged = isset($_SESSION['user_id']);
$current = basename($_SERVER['PHP_SELF']); // deteksi file aktif

// helper: tentukan link dashboard berdasarkan role
function dashboard_link_for_role() {
    $role = $_SESSION['user_role'] ?? 'user';
    if ($role === 'admin') {
        return 'admin/admin_dashboard.php'; // atau 'admin/' kalau index.php di folder admin
    }
    return 'users/users_dashboard.php'; // atau 'users/'
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapak Kita</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="bg-gray-900 fixed top-0 right-0 left-0">
        <nav aria-label="Global" class="page-container mx-auto flex max-w-7xl items-center justify-between p-4 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto" />
                </a>
                <a href="index.php" class="text-white font-bold text-xl pl-4">
                    Lapak Kita
                </a>
            </div>
            <el-popover-group class="hidden lg:flex lg:gap-x-12">
                <a href="index.php" class="font-semibold text-white">Beranda</a>
                <a href="articles.php" class="font-semibold text-white">Artikel</a>
                <a href="about.php" class="font-semibold text-white">Tentang</a>
                <a href="contact.php" class="font-semibold text-white">Kontak</a>
            </el-popover-group>

            <?php if(!$logged): ?>
            <!-- kalo ga login ada daftar sama login -->
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="register.php">
                        <button class="bg-transparent hover:bg-white text-white font-semibold hover:text-black py-1 px-4 border border-white hover:border-transparent rounded-full mr-4">
                            Daftar
                        </button>
                    </a>    
                    <a href="login.php">
                        <button class="bg-transparent hover:bg-white text-white font-semibold hover:text-black py-1 px-4 border border-white hover:border-transparent rounded-full">
                            Masuk
                        </button>
                    </a>
                </div>

            <!-- kalo login ada profile dropdown -->
            <?php else: ?>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end" id="profileDropdownRoot">
                <button id="profileBtn" aria-expanded="false" aria-haspopup="true"
                        class="flex items-center gap-3 px-3 rounded hover:bg-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-white">
                    <!-- Avatar (ui-avatars) -->
                    <img
                    src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>&background=4f46e5&color=fff&rounded=true"
                    alt="avatar"
                    class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                    <span class="text-sm text-white"><?= e($_SESSION['user_name'] ?? 'User') ?></span>
                    <!-- caret -->
                    <svg id="caret" class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div id="profileDropdown" class="hidden dropdown-enter absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded-md shadow-lg ring-1 ring-black/10 z-50 overflow-hidden">
                    <a href="<?= dashboard_link_for_role() ?>" class="block px-4 py-2 text-sm hover:bg-gray-100">Dashboard</a>
                    <form action="logout.php" method="POST" class="m-0">
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
                </div>
            <?php endif; ?>

        </nav>
    </header>
    <main class="flex-grow page-container px-4 py-20">
</body>
</html>

<script>
  // Dropdown logic: toggle + close on outside click + ESC
  (function(){
    const btn = document.getElementById('profileBtn');
    const dd = document.getElementById('profileDropdown');
    if (!btn || !dd) return;

    function openDropdown() {
      dd.classList.remove('hidden');
      btn.setAttribute('aria-expanded', 'true');
    }
    function closeDropdown() {
      dd.classList.add('hidden');
      btn.setAttribute('aria-expanded', 'false');
    }
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (dd.classList.contains('hidden')) openDropdown(); else closeDropdown();
    });

    // click outside
    document.addEventListener('click', (e) => {
      if (!dd.classList.contains('hidden')) {
        if (!dd.contains(e.target) && !btn.contains(e.target)) closeDropdown();
      }
    });

    // esc
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeDropdown();
    });
  })();
</script>