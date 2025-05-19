<?php
$host = "mysql-voting"; // atau bisa jadi "db" tergantung nama service MySQL di Coolify
$user = "voting";
$pass = "pemilihan123";
$db   = "pemilihan_ketua";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
