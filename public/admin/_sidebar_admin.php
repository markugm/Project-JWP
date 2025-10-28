<?php
// public/admin/_sidebar_admin.php

// Ambil nama user untuk ditampilkan di sidebar
// Asumsi $_SESSION['user_name'] tersedia setelah login
$userName = $_SESSION['user_name'] ?? 'Admin Lapak Kita';
$currentUrl = $_SERVER['PHP_SELF'];
$basePath = '/Project-JWP/public'; // Path dasar ke direktori admin

?>

<!-- Load Tailwind CSS (asumsi sudah di-setup di layout utama atau menggunakan CDN di file index.php) -->
<!-- Gunakan link ini jika belum di-load di file utama: <script src="https://cdn.tailwindcss.com"></script> -->

<nav class="w-64 bg-white border-r border-gray-200 flex flex-col h-full sticky top-0" style="min-height: 100vh;">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Dashboard Admin</h2>
    </div>

    <!-- Bagian Profil & Info User -->
    <div class="p-6 flex flex-col items-center border-b border-gray-200">
        <!-- Placeholder Avatar (sesuai wireframe) -->
        <div class="w-20 h-20 bg-gray-400 rounded-full mb-3 shadow-md"></div>
        <p class="text-sm text-gray-500">masuk sebagai</p>
        <p class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($userName) ?></p>
    </div>

    <!-- Navigasi Menu -->
    <div class="flex-1 p-4 space-y-2">
        <?php
        $navItems = [
            ['name' => 'Beranda', 'link' => $basePath . '/index.php'],
            // Tambahkan menu admin lain di sini
        ];
        
        foreach ($navItems as $item):
            // Tentukan apakah item ini adalah halaman yang sedang aktif
            $isActive = strpos($currentUrl, $item['link']) !== false;
            $class = $isActive 
                ? 'bg-indigo-100 text-indigo-700 font-semibold border-indigo-500' 
                : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600 border-transparent';
        ?>
            <a href="<?= $item['link'] ?>" class="flex items-center p-3 rounded-lg transition-colors border-l-4 <?= $class ?>">
                <!-- Ikon placeholder (bisa diganti dengan Lucide/FontAwesome jika tersedia) -->
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span><?= $item['name'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Menu Keluar (Logout) di bagian bawah -->
    <div class="p-4 border-t border-gray-200">
        <a href="<?= $basePath . '/logout.php' ?>" class="flex items-center p-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Keluar</span>
        </a>
    </div>
</nav>