<?php
$host = getenv('DB_HOST') ?: 'mysql-voting';  // 'mysql' = nama container database di Coolify
$user = getenv('DB_USER') ?: 'voting';
$pass = getenv('DB_PASS') ?: 'pemilihan123';
$db   = getenv('DB_NAME') ?: 'pemilihan_ketua';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
