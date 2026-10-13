<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";


$id = $_GET['id'];


$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id'");
$data = mysqli_fetch_assoc($query);


if (!$data) {
    echo "Data admin tidak ditemukan.";
    exit;
}

if (isset($_POST['update'])) {

    $username  = $_POST['username'];
    $nama_admin = $_POST['nama_admin'];

    $update = mysqli_query($koneksi, "
        UPDATE admin SET
        username='$username',
        nama_admin='$nama_admin'
        WHERE id_admin='$id'
    ");

    if ($update) {
        header("Location: data_admin.php");
        exit;
    } else {
        echo "Gagal mengubah data admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        h2 {
            margin-bottom: 25px;
            color: #172b4d;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            background: #2864e8;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .kembali {
            margin-left: 10px;
            text-decoration: none;
            color: #2864e8;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Admin</h2>

    <form method="POST">

        <label>Username</label>
        <input 
            type="text" 
            name="username" 
            value="<?= htmlspecialchars($data['username']); ?>"
            required
        >

        <label>Nama Admin</label>
        <input 
            type="text" 
            name="nama_admin" 
            value="<?= htmlspecialchars($data['nama_admin']); ?>"
            required
        >

        <button type="submit" name="update">
            Simpan Perubahan
        </button>

        <a href="data_admin.php" class="kembali">
            Kembali
        </a>

    </form>

</div>

</body>
</html>