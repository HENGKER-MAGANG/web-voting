<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Gagal menambahkan admin.";
    }
}
?>
