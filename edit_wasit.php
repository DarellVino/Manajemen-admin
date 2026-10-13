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

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM wasit WHERE id_wasit = $id"
);

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: wasit.php");
    exit;
}


if (isset($_POST['update'])) {

    $nama_wasit = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_wasit']
    );

    $jenis_game = mysqli_real_escape_string(
        $koneksi,
        $_POST['jenis_game']
    );

    $no_hp = mysqli_real_escape_string(
        $koneksi,
        $_POST['no_hp']
    );

    $email = mysqli_real_escape_string(
        $koneksi,
        $_POST['email']
    );

    mysqli_query(
        $koneksi,
        "UPDATE wasit SET
            nama_wasit = '$nama_wasit',
            jenis_game = '$jenis_game',
            no_hp = '$no_hp',
            email = '$email'
        WHERE id_wasit = $id"
    );

    header("Location: wasit.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Edit Wasit | Esport Arena</title>

    <link rel="stylesheet"
        href="assets/css/style.css">

</head>

<body>

    <main class="main">

        <div class="content-box">

            <h2>
                Edit Wasit
            </h2>

            <p class="description">
                Ubah data wasit pertandingan esport.
            </p>


            <form method="POST">

                <div class="form-group">

                    <label>
                        Nama Wasit
                    </label>

                    <input
                        type="text"
                        name="nama_wasit"
                        value="<?= htmlspecialchars($data['nama_wasit']); ?>"
                        required>

                </div>


                <div class="form-group">

                    <label>
                        Jenis Game
                    </label>

                    <input
                        type="text"
                        name="jenis_game"
                        value="<?= htmlspecialchars($data['jenis_game']); ?>"
                        required>

                </div>


                <div class="form-group">

                    <label>
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="<?= htmlspecialchars($data['no_hp']); ?>"
                        required>

                </div>


                <div class="form-group">

                    <label>
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?= htmlspecialchars($data['email']); ?>"
                        required>

                </div>


                <button
                    type="submit"
                    name="update"
                    class="btn btn-primary">

                    💾 Simpan Perubahan

                </button>


                <a
                    href="wasit.php"
                    class="btn"
                    style="
                    background:#e2e8f0;
                    color:#334155;
                    margin-left:8px;
                ">

                    Kembali

                </a>

            </form>

        </div>

    </main>

</body>

</html>