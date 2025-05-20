<?php
include '../koneksi.php';
$id = $_GET['id'];

// Hapus data di tabel suara terlebih dahulu
mysqli_query($koneksi, "DELETE FROM suara WHERE id_anggota = '$id'");

// Lalu hapus data anggota
mysqli_query($koneksi, "DELETE FROM anggota WHERE id = '$id'");

header("location:data_anggota.php?pesan=hapus_sukses");
?>
