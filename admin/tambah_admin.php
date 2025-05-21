<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek jika username sudah ada
    $check = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username sudah terdaftar!'); window.location.href='dashboard.php';</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO admin (username, password) VALUES ('$username', '$password')");
        if ($insert) {
            echo "<script>alert('Admin berhasil ditambahkan'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan admin'); window.location.href='dashboard.php';</script>";
        }
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
