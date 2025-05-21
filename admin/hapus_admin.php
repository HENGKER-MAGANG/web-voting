<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('admin');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Jangan izinkan hapus user admin utama (misal id 1)
    if ($id == 1) {
        echo "<script>alert('Admin utama tidak dapat dihapus!'); window.location.href='dashboard.php';</script>";
        exit;
    }

    $hapus = mysqli_query($conn, "DELETE FROM admin WHERE id = $id");
    if ($hapus) {
        echo "<script>alert('Admin berhasil dihapus'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus admin'); window.location.href='dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
