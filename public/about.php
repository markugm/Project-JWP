<?php
// public/about.php
require_once __DIR__ . '/../config/config.php'; // optional, kalau butuh session atau config
require_once __DIR__ . '/../app/function.php'; // untuk fungsi e()
include __DIR__ . '/_header.php';
?>

<main class="max-w-6xl mx-auto px-6 py-12 md:py-16">
  
  <!-- Hero Section About -->
  <section class="text-center mb-16 pt-10">
    <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-4">
      Tentang <span class="text-indigo-600">Lapak Kita</span>
    </h1>
    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
      Portal informasi terpercaya yang berfokus pada eksplorasi dunia teknologi,
      pengembangan web, dan inovasi bisnis digital.
    </p>
  </section>

  <!-- Visi & Misi (Menggunakan layout grid yang lebih elegan) -->
  <section class="grid gap-8 md:grid-cols-3 mb-16">
    
    <div class="bg-white border border-indigo-100 rounded-xl shadow-lg p-6 md:p-8 hover:shadow-xl transition duration-200">
      <h2 class="text-2xl font-bold text-indigo-700 mb-3">Visi Kami</h2>
      <p class="text-base text-gray-700">
        Menjadi sumber referensi utama di Indonesia bagi para profesional dan antusias
        yang ingin memahami dan menguasai tren teknologi terbaru, dari kode hingga manajemen produk.
      </p>
    </div>

    <div class="bg-white border border-purple-100 rounded-xl shadow-lg p-6 md:p-8 hover:shadow-xl transition duration-200">
      <h2 class="text-2xl font-bold text-purple-700 mb-3">Misi Kami</h2>
      <p class="text-base text-gray-700">
        Menyediakan konten artikel yang mendalam, terstruktur, dan mudah dipahami,
        membantu pembaca mentransformasi wawasan menjadi aksi nyata.
      </p>
    </div>

    <div class="bg-white border border-gray-100 rounded-xl shadow-lg p-6 md:p-8 hover:shadow-xl transition duration-200">
      <h2 class="text-2xl font-bold text-gray-700 mb-3">Nilai Inti</h2>
      <ul class="list-disc list-inside text-base text-gray-700 space-y-2 pl-4">
        <li>Akurasi Informasi</li>
        <li>Kedalaman Analisis</li>
        <li>Relevansi Industri</li>
      </ul>
    </div>
  </section>

  <!-- Detail Fitur Web (Dipertahankan, tapi disesuaikan kontennya) -->
  <section class="max-w-4xl mx-auto mb-16 bg-white border border-gray-200 rounded-xl shadow-lg p-6 md:p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b pb-3">Apa yang Kami Tawarkan?</h2>
    
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.204 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.796 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.796 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.204 18 16.5 18s-3.332.477-4.5 1.253"></path></svg>
                Akses Publik ke Semua Artikel
            </h3>
            <p class="text-gray-600 text-base">
                Semua pengunjung dapat membaca artikel, menjelajahi kategori, dan melihat post secara detail tanpa perlu registrasi atau *login*.
            </p>
        </div>
        <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Panel Administrasi (CRUD)
            </h3>
            <p class="text-gray-600 text-base">
                Tim Admin dan Editor memiliki akses ke dashboard khusus untuk mengelola, membuat, mengedit, dan menghapus artikel dengan sistem CRUD yang aman.
            </p>
        </div>
    </div>
  </section>

  <!-- User Roles & Permissions (Dibuat lebih ringkas) -->
  <section class="max-w-4xl mx-auto mb-16 bg-gray-50 border border-gray-300 rounded-xl p-6 md:p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Akses dan Kontribusi</h2>
    
    <div class="md:flex md:justify-between md:items-center">
        <div class="md:w-1/2 mb-4 md:mb-0">
            <ul class="list-disc list-inside text-base text-gray-700 space-y-2 pl-4">
                <li><strong>Pengunjung</strong>: Akses penuh ke semua konten artikel.</li>
                <li><strong>Admin</strong>: Akses penuh ke Dashboard, CRUD Artikel, dan manajemen sistem.</li>
            </ul>
        </div>

        <div class="md:w-1/2 md:text-right">
            <?php 
            // Cek apakah user sudah login dan role-nya admin
            $is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
            ?>
            <?php if ($is_admin): ?>
              <a href="admin/articles/index.php" class="inline-block px-5 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md">
                Kelola Artikel
              </a>
            <?php else: ?>
              <p class="text-base text-gray-600">
                Jika Anda adalah administrator, silakan <a href="/login.php" class="text-indigo-600 font-medium underline hover:text-indigo-800">login</a>.
              </p>
            <?php endif; ?>
        </div>
    </div>
  </section>

  <!-- Ajakan Berkontribusi / Kontak -->
  <section class="max-w-4xl mx-auto text-center pt-8 border-t border-gray-200">
    <h2 class="text-2xl font-bold text-gray-800 mb-3">Punya Pertanyaan?</h2>
    <p class="text-base text-gray-600 mb-6">
      Tim kami selalu siap membantu. Jangan ragu untuk menghubungi kami untuk pertanyaan teknis, peluang kolaborasi, atau sekadar menyapa.
    </p>
    <a href="contact.php" class="inline-block px-6 py-3 rounded-lg bg-purple-600 text-white font-semibold hover:bg-purple-700 transition shadow-lg">
      Hubungi Kami Sekarang
    </a>
  </section>

</main>

<?php
include __DIR__ . '/_footer.php';
