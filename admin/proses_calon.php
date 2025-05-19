<?php
include '../includes/db.php';

$nama = $_POST['nama'];
$visi = $_POST['visi'];
$misi = $_POST['misi'];

// Upload foto
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
$lokasi = "../calon_foto/";
move_uploaded_file($tmp, $lokasi . $foto);

$query = "INSERT INTO calon (nama, visi, misi, foto) VALUES ('$nama', '$visi', '$misi', '$foto')";
mysqli_query($conn, $query);

header('Location: dashboard.php');
