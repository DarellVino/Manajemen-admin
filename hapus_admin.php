<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = mysqli_query($koneksi, 
        "DELETE FROM admin WHERE id_admin='$id'"
    );

    if ($query) {
        header("Location: data_admin.php");
        exit;
    } else {
        echo "Gagal menghapus data admin.";
    }
}
?>