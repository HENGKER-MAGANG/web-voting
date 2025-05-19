<?php
$host = getenv('DB_HOST') ?: 'q0wk40ksgs448kg80884wk44';  // 'mysql' = nama container database di Coolify
$user = getenv('DB_USER') ?: 'mysql';
$pass = getenv('DB_PASS') ?: 'pemilihan123';
$db   = getenv('DB_NAME') ?: 'pemilihan_ketua';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
