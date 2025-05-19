<?php
// Ambil host dari environment variable atau default ke 'localhost'
$host = getenv('DB_HOST') ?: 'q0wk40ksgs448kg80884wk44'; // 'mysql-db' = nama container MySQL
$user = getenv('DB_USER') ?: 'voting';
$pass = getenv('DB_PASS') ?: 'pemilihan123';
$db   = getenv('DB_NAME') ?: 'pemilihan_ketua';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
