<?php

$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "esport_arena"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>