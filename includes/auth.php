<?php
session_start();

function cekLogin($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header('Location: ../index.php');
        exit;
    }
}
