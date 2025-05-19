<?php
// Koneksi ke database
include 'includes/db.php'; // pastikan path ini sesuai struktur project kamu

$username = 'admin'; // username perdana
$passwordPlain = 'admin123'; // password perdana (bisa diubah)

// Hash password
$hashedPassword = password_hash($passwordPlain, PASSWORD_DEFAULT);

// Cek apakah sudah ada admin dengan username ini
$cek = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
if (mysqli_num_rows($cek) > 0) {
    echo "❌ Admin dengan username '$username' sudah ada di database.";
    exit;
}

// Insert ke database
$query = "INSERT INTO admin (username, password) VALUES ('$username', '$hashedPassword')";
if (mysqli_query($conn, $query)) {
    echo "✅ Admin berhasil dibuat.<br>Username: <b>$username</b><br>Password: <b>$passwordPlain</b>";
} else {
    echo "❌ Gagal menambahkan admin: " . mysqli_error($conn);
}
?>
