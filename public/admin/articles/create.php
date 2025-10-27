<?php
// public/admin/articles/create.php
require_once __DIR__ . '/../../../app/auth.php';
require_admin();
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../app/function.php';

$errors = [];
$title = $content = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $content = trim($_POST['content'] ?? '');

  if ($title === '' || $content === '') {
    $errors[] = 'Judul dan isi artikel wajib diisi.';
  }

  // handle image upload (opsional)
  $imagePath = null;
  if (!empty($_FILES['featured_image']['name'])) {
    $allowed = ['image/jpeg','image/png','image/webp'];
    if (!in_array($_FILES['featured_image']['type'], $allowed)) {
      $errors[] = 'Tipe file tidak diperbolehkan. Gunakan JPG/PNG/WEBP.';
    } else {
      $ext = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
      $fname = 'uploads/' . uniqid('img_') . '.' . $ext;
      
      // FIX: Mengoreksi path target upload gambar agar mengacu ke folder public/uploads/
      // Go up 2 levels (dari articles/ ke admin/ ke public/)
      $target = __DIR__ . '/../../../public/' . $fname; 
      
      if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
        $errors[] = 'Gagal mengunggah gambar. Pastikan folder uploads sudah ada dan writable.';
      } else {
        $imagePath = $fname; // simpan relatif ke public/
      }
    }
  }

  if (empty($errors)) {
    $slug = slugify($title);
    // jika slug duplicate, tambahkan unique suffix
    $origSlug = $slug;
    $i = 1;
    while (true) {
      $stmt = mysqli_prepare($conn, "SELECT id FROM articles WHERE slug = ?");
      mysqli_stmt_bind_param($stmt, "s", $slug);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      if (mysqli_stmt_num_rows($stmt) === 0) {
        mysqli_stmt_close($stmt);
        break;
      }
      mysqli_stmt_close($stmt);
      $slug = $origSlug . '-' . $i++;
    }

    $author_id = $_SESSION['user_id'] ?? null;
    $stmt = mysqli_prepare($conn, "INSERT INTO articles (title, slug, content, featured_image, author_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $slug, $content, $imagePath, $author_id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($ok) {
      header('Location: index.php?created=1');
      exit;
    } else {
      $errors[] = 'Gagal menyimpan artikel ke database.';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Artikel Baru | Admin Lapak Kita</title>
    <!-- Load Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb;
        }
        /* Layout untuk sidebar dan main content */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        /* TinyMCE styling agar konsisten dengan Tailwind */
        .tox .tox-menubar, .tox .tox-toolbar {
            border-radius: 0.5rem 0.5rem 0 0;
            background-color: #f9fafb; /* Lighter background for toolbar */
            border-color: #e5e7eb;
        }
        .tox .tox-edit-area {
             border-radius: 0 0 0.5rem 0.5rem;
             border-color: #e5e7eb;
        }
    </style>
</head>
<body class="admin-layout">

    <!-- 1. SIDEBAR (Kiri) - Menggunakan file yang sudah diperbarui -->
    <?php include __DIR__ . '/../_sidebar_admin.php'; ?>

    <!-- 2. MAIN CONTENT (Kanan) -->
    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
            
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Artikel</h1>

            <?php if (!empty($errors)): ?>
              <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                <ul class="list-disc pl-5">
                  <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Judul -->
                <div>
                  <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul</label>
                  <input 
                      type="text"
                      id="title"
                      name="title" 
                      value="<?= e($title) ?>" 
                      class="mt-1 block w-full border border-gray-300 px-4 py-2 rounded-lg text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm" 
                      placeholder="Masukkan judul artikel"
                      required>
                </div>

                <!-- Isi Artikel (TinyMCE) -->
                <div>
                  <label for="editor" class="block text-sm font-semibold text-gray-700 mb-1">Isi</label>
                  <textarea id="editor" name="content" rows="12" class="rounded-lg border-gray-300"><?= e($content) ?></textarea>
                </div>

                <!-- Gambar Utama -->
                <div>
                  <label for="featured_image" class="block text-sm font-semibold text-gray-700 mb-1">Gambar Utama (opsional)</label>
                  <input type="file" id="featured_image" name="featured_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center gap-4 pt-4">
                  <button class="bg-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-indigo-700 transition shadow-md" type="submit">
                    Simpan Artikel
                  </button>
                  <a href="index.php" class="text-gray-600 font-medium hover:text-gray-800 transition">
                    Batal
                  </a>
                </div>
            </form>
        </div>
    </main>

    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/pveptn3rvibyvg0w1znpaddkzpnzut5pfy7bp4qlmyov14pl/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
      selector: '#editor',
      height: 400,
      plugins: 'image link media table lists code autoresize',
      toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | code',
      menubar: 'file edit view insert format tools table help',
      branding: false,
      skin: 'oxide',
      content_css: 'default'
    });
    </script>

</body>
</html>
