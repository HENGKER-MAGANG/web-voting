<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('admin');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus foto calon
    $foto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM calon WHERE id = $id"))['foto'];
    if ($foto && file_exists("../calon_foto/" . $foto)) {
        unlink("../calon_foto/" . $foto);
    }

    // Hapus suara terkait
    mysqli_query($conn, "DELETE FROM suara WHERE id_calon = $id");

    // Hapus calon
    mysqli_query($conn, "DELETE FROM calon WHERE id = $id");
}

header("Location: dashboard.php");
exit;
