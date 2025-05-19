<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Cek admin
    $admin = mysqli_query($conn, "SELECT * FROM admin WHERE username='$login'");
    if ($a = mysqli_fetch_assoc($admin)) {
        if (password_verify($password, $a['password'])) {
            $_SESSION['role'] = 'admin';
            $_SESSION['id'] = $a['id'];
            header('Location: admin/dashboard.php');
            exit;
        }
    }

    // Cek anggota via NISN
    $anggota = mysqli_query($conn, "SELECT * FROM anggota WHERE nisn='$login'");
    if ($u = mysqli_fetch_assoc($anggota)) {
        if (password_verify($password, $u['password'])) {
            $_SESSION['role'] = 'anggota';
            $_SESSION['id'] = $u['id'];
            header('Location: anggota/dashboard.php');
            exit;
        }
    }

    $error = "Login gagal!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Pemilihan Ketua</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center p-4">

    <div class="bg-white shadow-xl rounded-xl overflow-hidden w-full max-w-4xl grid md:grid-cols-2">
        <!-- Gambar atau Ilustrasi -->
        <div class="bg-blue-600 text-white flex items-center justify-center p-6">
            <div class="text-center">
                <img src="logo.png" alt="Login" class="w-48 mx-auto mb-4">
                <h2 class="text-2xl font-bold">Selamat Datang 👋</h2>
                <p class="text-sm">Silakan login untuk mengikuti pemilihan ketua komunitas</p>
            </div>
        </div>

        <!-- Form Login -->
        <form method="POST" class="p-8 bg-white">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Login Akun</h2>

            <?php if (!empty($error)): ?>
                <p class="bg-red-100 text-red-600 px-4 py-2 rounded mb-4"><?= $error ?></p>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Username / NISN</label>
                <input name="login" required placeholder="Username (Admin) / NISN (Anggota)"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Password</label>
                <input type="password" name="password" required placeholder="********"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition shadow">
                Login
            </button>

            <p class="mt-6 text-sm text-gray-500 text-center">© <?= date('Y') ?> Ikhsan Pratama SMKN 2 PINRANG</p>
        </form>
    </div>

</body>
</html>
