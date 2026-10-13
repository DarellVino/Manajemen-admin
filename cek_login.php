<?php

session_start();

include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: login.php");
    exit;

}

$username = trim($_POST['username'] ?? "");
$password = $_POST['password'] ?? "";

if ($username == "" || $password == "") {

    $_SESSION['pesan'] =
        "Username dan password wajib diisi.";

    header("Location: login.php");
    exit;

}

$username = mysqli_real_escape_string(
    $koneksi,
    $username
);

$password_md5 = md5($password);

$query = mysqli_query(
    $koneksi,
    "SELECT *
     FROM admin
     WHERE username='$username'
     AND password='$password_md5'
     LIMIT 1"
);

if (!$query) {

    $_SESSION['pesan'] =
        "Terjadi kesalahan database.";

    header("Location: login.php");
    exit;

}

if (mysqli_num_rows($query) == 1) {

    $admin = mysqli_fetch_assoc($query);

    $_SESSION['id_admin'] =
        $admin['id_admin'];

    $_SESSION['username'] =
        $admin['username'];

    $_SESSION['nama_admin'] =
        $admin['nama_admin'];

    header("Location: dashboard.php");

    exit;

} else {

    $_SESSION['pesan'] =
        "Username atau password salah.";

    header("Location: login.php");

    exit;

}

?>