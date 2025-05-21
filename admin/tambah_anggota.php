<?php
include '../includes/db.php';

$nama = $_POST['nama'] ?? '';
$nisn = $_POST['nisn'] ?? '';
$password = $_POST['password'] ?? '';

if (!$nama || !$nisn || !$password) {
    http_response_code(400);
    echo "Data tidak lengkap.";
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah nisn sudah ada
$cek = mysqli_query($conn, "SELECT * FROM anggota WHERE nisn = '$nisn'");
if (mysqli_num_rows($cek) > 0) {
    http_response_code(409);
    echo "NISN sudah terdaftar.";
    exit;
}

// Simpan ke database
$query = "INSERT INTO anggota (nama, nisn, password) VALUES ('$nama', '$nisn', '$passwordHash')";
if (mysqli_query($conn, $query)) {
    echo "Berhasil ditambahkan.";
} else {
    http_response_code(500);
    echo "Gagal menambahkan anggota.";
}
