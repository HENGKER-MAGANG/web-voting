<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('anggota');

$id_anggota = $_SESSION['id'];
$id_calon = $_POST['id_calon'];

// Cek apakah sudah memilih
$cek = mysqli_query($conn, "SELECT sudah_memilih FROM anggota WHERE id=$id_anggota");
$status = mysqli_fetch_assoc($cek)['sudah_memilih'];

if (!$status) {
    mysqli_query($conn, "INSERT INTO suara (id_anggota, id_calon) VALUES ($id_anggota, $id_calon)");
    mysqli_query($conn, "UPDATE anggota SET sudah_memilih=1 WHERE id=$id_anggota");
}

header("Location: dashboard.php");
