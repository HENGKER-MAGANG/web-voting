<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('admin');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM anggota WHERE id = $id");
}

header("Location: dashboard.php");
exit;
