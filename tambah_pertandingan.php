<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";


if (isset($_POST['simpan'])) {

    $jenis_game         = $_POST['jenis_game'];
    $nama_pertandingan  = $_POST['nama_pertandingan'];
    $tim_a              = $_POST['tim_a'];
    $tim_b              = $_POST['tim_b'];
    $tanggal            = $_POST['tanggal'];
    $waktu              = $_POST['waktu'];
    $status             = $_POST['status'];
    $hasil              = $_POST['hasil'];


    $query = mysqli_query(
        $koneksi,
        "INSERT INTO pertandingan
        (
            jenis_game,
            nama_pertandingan,
            tim_a,
            tim_b,
            tanggal,
            waktu,
            status,
            hasil
        )
        VALUES
        (
            '$jenis_game',
            '$nama_pertandingan',
            '$tim_a',
            '$tim_b',
            '$tanggal',
            '$waktu',
            '$status',
            '$hasil'
        )"
    );


    if ($query) {

        header("Location: pertandingan.php");
        exit;
    } else {

        $error = "Data pertandingan gagal disimpan.";
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
        Tambah Pertandingan | Esport Arena
    </title>

    <link rel="stylesheet"
        href="assets/css/style.css">

</head>


<body>


    <!-- SIDEBAR -->

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

        <a href="pertandingan.php" class="active">
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


        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h2>
                    Tambah Pertandingan
                </h2>

                <p>
                    Tambahkan data pertandingan baru.
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
                Form Tambah Pertandingan
            </h2>


            <p class="description">
                Isi data pertandingan dengan lengkap.
            </p>


            <?php if (isset($error)): ?>

                <div class="alert">

                    <?= htmlspecialchars($error); ?>

                </div>

            <?php endif; ?>


            <form method="POST">


                <!-- JENIS GAME -->

                <div class="form-group">

                    <label>
                        Jenis Game
                    </label>

                    <select
                        name="jenis_game"
                        class="form-control"
                        required>

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



                <!-- NAMA PERTANDINGAN -->

                <div class="form-group">

                    <label>
                        Nama Pertandingan
                    </label>

                    <input
                        type="text"
                        name="nama_pertandingan"
                        class="form-control"
                        placeholder="Contoh: Semifinal 1"
                        required>

                </div>



                <!-- TIM A -->

                <div class="form-group">

                    <label>
                        Tim A
                    </label>

                    <input
                        type="text"
                        name="tim_a"
                        class="form-control"
                        placeholder="Nama tim A"
                        required>

                </div>



                <!-- TIM B -->

                <div class="form-group">

                    <label>
                        Tim B
                    </label>

                    <input
                        type="text"
                        name="tim_b"
                        class="form-control"
                        placeholder="Nama tim B"
                        required>

                </div>



                <!-- TANGGAL -->

                <div class="form-group">

                    <label>
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        required>

                </div>



                <!-- WAKTU -->

                <div class="form-group">

                    <label>
                        Waktu
                    </label>

                    <input
                        type="time"
                        name="waktu"
                        class="form-control"
                        required>

                </div>



                <!-- STATUS -->

                <div class="form-group">

                    <label>
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-control"
                        required>

                        <option value="Belum Dimulai">
                            Belum Dimulai
                        </option>

                        <option value="Berlangsung">
                            Berlangsung
                        </option>

                        <option value="Selesai">
                            Selesai
                        </option>

                    </select>

                </div>



                <!-- HASIL -->

                <div class="form-group">

                    <label>
                        Hasil
                    </label>

                    <input
                        type="text"
                        name="hasil"
                        class="form-control"
                        placeholder="Contoh: 2 - 1">

                </div>



                <!-- BUTTON -->

                <div class="form-buttons">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn btn-primary">

                        💾 Simpan Pertandingan

                    </button>


                    <a
                        href="pertandingan.php"
                        class="btn btn-secondary">

                        Kembali

                    </a>

                </div>


            </form>


        </div>


    </main>


</body>

</html>