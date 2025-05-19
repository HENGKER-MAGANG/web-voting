<?php
$host = getenv('DB_HOST') ?: 'igg8cog4wkw40444cko8gkkk';  // 'mysql' = nama container database di Coolify
$user = getenv('DB_USER') ?: 'pemilihan-db';
$pass = getenv('DB_PASS') ?: 'pemilihan123';
$db   = getenv('DB_NAME') ?: 'pemilihan_ketua';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
