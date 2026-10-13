<?php

include 'koneksi.php';

$id = $_GET['id'] ?? '';

if ($id == '') {

    header("Location: pertandingan.php");
    exit;
}


$query = mysqli_query(
    $koneksi,
    "DELETE FROM pertandingan
     WHERE id_pertandingan='$id'"
);


header("Location: pertandingan.php");

exit;
