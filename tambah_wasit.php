<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";


/* =========================
   SIMPAN DATA WASIT
========================= */

if (isset($_POST['simpan'])) {

    $nama_wasit = $_POST['nama_wasit'];
    $jenis_game = $_POST['jenis_game'];
    $no_hp      = $_POST['no_hp'];
    $email      = $_POST['email'];


    $query = mysqli_query(
        $koneksi,
        "INSERT INTO wasit
        (
            nama_wasit,
            jenis_game,
            no_hp,
            email
        )
        VALUES
        (
            '$nama_wasit',
            '$jenis_game',
            '$no_hp',
            '$email'
        )"
    );


    if ($query) {

        header("Location: wasit.php");
        exit;

    } else {

        $error = "Data wasit gagal disimpan.";

    }
}

?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Tambah Wasit | Esport Arena
    </title>

    <link rel="stylesheet"
        href="assets/css/style.css">

</head>


<body>


<!-- =========================
     SIDEBAR
========================= -->

<aside class="sidebar">

    <div class="logo">
        TOURNAMENT <span>MANAGEMENT</span>
    </div>


    <div class="menu-title">
        MENU UTAMA
    </div>


    <a href="dashboard.php">
        Dashboard
    </a>


    <a href="turnamen.php">
        Turnamen
    </a>


    <a href="pertandingan.php">
        Pertandingan
    </a>


    <a href="wasit.php" class="active">
        Wasit
    </a>


    <a href="laporan_pertandingan.php">
        Pelaporan
    </a>


    <div class="menu-title">
        AKUN
    </div>


    <a href="logout.php">
        Logout
    </a>

</aside>



<!-- =========================
     MAIN
========================= -->

<main class="main">


    <!-- =========================
         TOPBAR
    ========================= -->

    <div class="topbar">

        <div>

            <h2>
                Tambah Wasit
            </h2>

            <p>
                Tambahkan data wasit pertandingan esport.
            </p>

        </div>


        <div class="profile">

            <div class="avatar">

                <?= strtoupper(
                    substr(
                        $_SESSION['nama_admin'] ?? 'A',
                        0,
                        1
                    )
                ); ?>

            </div>


            <div>

                <strong>

                    <?= htmlspecialchars(
                        $_SESSION['nama_admin']
                        ?? 'Administrator'
                    ); ?>

                </strong>

                <small>
                    Administrator
                </small>

            </div>

        </div>

    </div>



    <!-- =========================
         FORM
    ========================= -->

    <div class="content-box">

        <h2>
            Form Tambah Wasit
        </h2>


        <p class="description">
            Isi data wasit dengan lengkap.
        </p>


        <!-- ERROR -->

        <?php if (isset($error)): ?>

            <div class="alert">

                <?= htmlspecialchars($error); ?>

            </div>

        <?php endif; ?>



        <!-- FORM -->

        <form method="POST">


            <!-- NAMA WASIT -->

            <div class="form-group">

                <label for="nama_wasit">
                    Nama Wasit
                </label>

                <input
                    type="text"
                    id="nama_wasit"
                    name="nama_wasit"
                    class="form-control"
                    placeholder="Masukkan nama wasit"
                    required
                >

            </div>



            <!-- JENIS GAME -->

            <div class="form-group">

                <label for="jenis_game">
                    Jenis Game
                </label>

                <select
                    id="jenis_game"
                    name="jenis_game"
                    class="form-control"
                    required
                >

                    <option value="">
                        -- Pilih Game --
                    </option>

                    <option value="Mobile Legends">
                        Mobile Legends
                    </option>

                    <option value="Free Fire">
                        Free Fire
                    </option>

                    <option value="PUBG Mobile">
                        PUBG Mobile
                    </option>

                    <option value="Valorant">
                        Valorant
                    </option>

                    <option value="EA Sports FC">
                        EA Sports FC
                    </option>

                </select>

            </div>



            <!-- NO HP -->

            <div class="form-group">

                <label for="no_hp">
                    No. HP
                </label>

                <input
                    type="text"
                    id="no_hp"
                    name="no_hp"
                    class="form-control"
                    placeholder="Contoh: 08123456789"
                    required
                >

            </div>



            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="Contoh: wasit@gmail.com"
                    required
                >

            </div>



            <!-- TOMBOL -->

            <div class="form-actions">

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-primary"
                >
                    Simpan Wasit
                </button>


                <a
                    href="wasit.php"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>


        </form>

    </div>


</main>


</body>

</html>