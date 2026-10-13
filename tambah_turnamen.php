<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";


/* =========================
   SIMPAN DATA TURNAMEN
========================= */

if (isset($_POST['simpan'])) {

    $nama_turnamen   = $_POST['nama_turnamen'];
    $jenis_game      = $_POST['jenis_game'];
    $penyelenggara   = $_POST['penyelenggara'];
    $tanggal_mulai   = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status          = $_POST['status'];


    $query = mysqli_query(
        $koneksi,
        "INSERT INTO turnamen
        (
            nama_turnamen,
            jenis_game,
            penyelenggara,
            tanggal_mulai,
            tanggal_selesai,
            status
        )
        VALUES
        (
            '$nama_turnamen',
            '$jenis_game',
            '$penyelenggara',
            '$tanggal_mulai',
            '$tanggal_selesai',
            '$status'
        )"
    );


    if ($query) {

        header("Location: turnamen.php");
        exit;

    } else {

        $error = "Data turnamen gagal disimpan.";

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
        Tambah Turnamen | Esport Arena
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


    <a href="turnamen.php" class="active">
        Turnamen
    </a>


    <a href="pertandingan.php">
        Pertandingan
    </a>


    <a href="wasit.php">
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
                Tambah Turnamen
            </h2>

            <p>
                Tambahkan data turnamen baru.
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
            Form Tambah Turnamen
        </h2>

        <p class="description">
            Isi data turnamen dengan lengkap.
        </p>


        <!-- ERROR -->

        <?php if (isset($error)): ?>

            <div class="alert">

                <?= htmlspecialchars($error); ?>

            </div>

        <?php endif; ?>



        <!-- FORM -->

        <form method="POST">


            <!-- NAMA TURNAMEN -->

            <div class="form-group">

                <label for="nama_turnamen">
                    Nama Turnamen
                </label>

                <input
                    type="text"
                    id="nama_turnamen"
                    name="nama_turnamen"
                    class="form-control"
                    placeholder="Contoh: Esport Arena Championship"
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



            <!-- PENYELENGGARA -->

            <div class="form-group">

                <label for="penyelenggara">
                    Penyelenggara
                </label>

                <input
                    type="text"
                    id="penyelenggara"
                    name="penyelenggara"
                    class="form-control"
                    placeholder="Masukkan nama penyelenggara"
                    required
                >

            </div>



            <!-- TANGGAL MULAI -->

            <div class="form-group">

                <label for="tanggal_mulai">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    id="tanggal_mulai"
                    name="tanggal_mulai"
                    class="form-control"
                    required
                >

            </div>



            <!-- TANGGAL SELESAI -->

            <div class="form-group">

                <label for="tanggal_selesai">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    id="tanggal_selesai"
                    name="tanggal_selesai"
                    class="form-control"
                    required
                >
                
            </div>



            <!-- STATUS -->

            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="form-control"
                    required
                >
                
                    <option value="Akan Datang">
                        Akan Datang
                    </option>

                    <option value="Berlangsung">
                        Berlangsung
                    </option>

                    <option value="Selesai">
                        Selesai
                    </option>

                </select>

            </div>



            <!-- TOMBOL -->

            <div class="form-actions">

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-primary"
                >
                    Simpan Turnamen
                </button>


                <a
                    href="turnamen.php"
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