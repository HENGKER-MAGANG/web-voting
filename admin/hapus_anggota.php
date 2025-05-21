<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('admin');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus dulu data suara yang terkait dengan anggota ini
    mysqli_query($conn, "DELETE FROM suara WHERE id_anggota = $id");

    // Lalu hapus data anggota
    mysqli_query($conn, "DELETE FROM anggota WHERE id = $id");
}

// Redirect kembali ke dashboard
header("Location: dashboard.php");
exit;