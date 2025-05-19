<?php
$host = "localhost";
$user = "root"; // sesuaikan dengan user database kamu
$pass = "";     // sesuaikan dengan password database kamu
$db   = "pemilihan_ketua";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
