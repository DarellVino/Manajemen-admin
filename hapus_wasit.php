<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: wasit.php");
    exit;
}

$id = intval($_GET['id']);

mysqli_query(
    $koneksi,
    "DELETE FROM wasit WHERE id_wasit = $id"
);

header("Location: wasit.php");
exit;

?>