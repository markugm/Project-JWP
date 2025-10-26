<?php include __DIR__ . '/_header.php'; ?>

<div class="pt-4 flex justify-center">
    <div class="block w-full max-w-md rounded-2xl border border-gray-700 p-8 shadow-xl">

    <div class="flex min-h-full flex-col justify-center px-4 py-4 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mb-3 text-center text-3xl font-bold text-black">Masuk</h1>
            <h2 class="text-center text-md text-black">Sign in to your account</h2>
        </div>
    
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="../app/process_login.php" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-800">Email</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" required autocomplete="email" class="block w-full rounded-md bg-gray-200 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-800 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm/6 font-medium text-gray-800">Kata Sandi</label>
                    <div class="mt-2">
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-gray-200 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-800 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Masuk</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Belum punya akun?
                <a href="register.php" class="font-semibold text-indigo-400 hover:text-indigo-300">Buat akun</a>
            </p>
        </div>
    </div>

    </div>
</div>

<!-- <div class="max-w-2xl mx-auto px-4 py-10">
  <h2 class="text-2xl font-semibold mb-2">Login</h2>
  <p class="text-sm text-gray-600 mb-6">Masuk untuk mengelola artikel atau mengirim komentar.</p>

  <form action="../app/process_login.php" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4">
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
      <input id="email" name="email" type="email" required class="mt-1 block w-full px-3 py-2 border rounded" />
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
      <input id="password" name="password" type="password" required class="mt-1 block w-full px-3 py-2 border rounded" />
    </div>

    <div class="flex items-center gap-3">
      <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Login</button>
      <a href="register.php" class="text-sm text-gray-600">Belum punya akun? Daftar</a>
    </div>
  </form>
</div> -->


<?php include __DIR__ . '/_footer.php'; ?>