<?php
// public/about.php
require_once __DIR__ . '/../config/config.php'; // optional, kalau butuh session atau config
// jika proyekmu menyimpan session di config, pastikan sudah di-include di header juga
include __DIR__ . '/_header.php';
?>

<main class="max-w-5xl mx-auto px-4 py-12">
  <section class="prose lg:prose-xl mx-auto mb-12">
    <h1>About</h1>
    <p>
      Welcome to <strong>My Web Blog</strong> — a simple learning project built to
      demonstrate basic PHP web app structure, user roles, and CRUD operations.
      This site is a training ground to practice building, maintaining, and
      securing a small web application.
    </p>
  </section>

  <section class="grid gap-8 md:grid-cols-2 mb-12">
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h2 class="text-lg font-semibold mb-2">Mission</h2>
      <p class="text-sm">
        To provide an approachable project that helps beginners learn PHP,
        database interaction (PDO), session-based authentication, and how to
        structure a small web application with role-based access.
      </p>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
      <h2 class="text-lg font-semibold mb-2">Core Features</h2>
      <ul class="list-disc list-inside text-sm space-y-1">
        <li>Public: read articles, view single posts, and submit contact messages</li>
        <li>Authenticated users: comment and like posts</li>
        <li>Admin: full CRUD for posts and user management</li>
        <li>Simple admin dashboard for management</li>
      </ul>
    </div>
  </section>

  <section class="mb-12">
    <div class="bg-gray-50 border rounded-lg p-6">
      <h2 class="text-lg font-semibold mb-3">User Roles & Permissions</h2>
      <p class="text-sm mb-3">
        This project uses a <strong>role-based</strong> approach:
      </p>
      <ul class="list-disc list-inside text-sm space-y-1 mb-4">
        <li><strong>Admin</strong>: create, read, update, delete posts and manage users.</li>
        <li><strong>User</strong>: read posts, comment, and like. No access to admin pages.</li>
      </ul>

      <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <div class="flex items-center gap-3">
          <a href="/public/admin/dashboard.php" class="inline-block px-4 py-2 rounded-md shadow-sm text-sm font-medium focus:outline-none">
            Go to Admin Dashboard
          </a>
        </div>
      <?php else: ?>
        <p class="text-sm text-gray-600">
          If you are an admin, please <a href="/public/login.php" class="underline">login</a> to access admin features.
        </p>
      <?php endif; ?>
    </div>
  </section>

  <section class="mb-12">
    <h2 class="text-lg font-semibold mb-3">How to Contribute / Learn</h2>
    <ol class="list-decimal list-inside text-sm space-y-2">
      <li>Clone the repo and read <code>README.md</code>.</li>
      <li>Set up your database via <code>config/config.php</code> and run <code>seed_users.php</code> to create an admin.</li>
      <li>Start by exploring the admin dashboard and the backend scripts in <code>app/</code>.</li>
    </ol>
  </section>

  <section class="text-sm text-gray-600">
    <h3 class="font-medium mb-2">Contact</h3>
    <p>
      For questions or help, use the <a href="/public/contact.php" class="underline">Contact page</a>.
    </p>
  </section>
</main>

<?php
include __DIR__ . '/_footer.php';
