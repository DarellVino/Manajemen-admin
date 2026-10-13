<?php

include 'koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $koneksi,
    "DELETE FROM turnamen WHERE id_turnamen='$id'"
);

header("Location: turnamen.php");

?>