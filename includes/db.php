<?php
$host = getenv('DB_HOST') ?: 'w4ss00w4c0wwg8048s48o8sw';  // 'mysql' = nama container database di Coolify
$user = getenv('DB_USER') ?: 'pemilihan-db';
$pass = getenv('DB_PASS') ?: 'pemilihan123';
$db   = getenv('DB_NAME') ?: 'pemilihan_ketua';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
