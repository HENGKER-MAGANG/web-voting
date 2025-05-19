<?php
include '../includes/db.php';

$nama = $_POST['nama'];
$nisn = $_POST['nisn'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO anggota (nama, nisn, password) VALUES ('$nama', '$nisn', '$password')";
mysqli_query($conn, $query);

header("Location: dashboard.php");
