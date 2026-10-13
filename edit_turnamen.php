<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";


/* AMBIL ID TURNAMEN */

$id = $_GET['id'] ?? '';

if ($id == '') {
    header("Location: turnamen.php");
    exit;
}


/* AMBIL DATA TURNAMEN */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM turnamen
     WHERE id_turnamen='$id'"
);

$data = mysqli_fetch_assoc($query);


if (!$data) {
    echo "Data turnamen tidak ditemukan.";
    exit;
}


/* PROSES UPDATE */

if (isset($_POST['update'])) {

    $nama_turnamen   = $_POST['nama_turnamen'];
    $jenis_game      = $_POST['jenis_game'];
    $penyelenggara   = $_POST['penyelenggara'];
    $tanggal_mulai   = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status          = $_POST['status'];


    $update = mysqli_query(
        $koneksi,
        "UPDATE turnamen SET

            nama_turnamen='$nama_turnamen',

            jenis_game='$jenis_game',

            penyelenggara='$penyelenggara',

            tanggal_mulai='$tanggal_mulai',

            tanggal_selesai='$tanggal_selesai',

            status='$status'

        WHERE id_turnamen='$id'"
    );


    if ($update) {

        header("Location: turnamen.php");
        exit;
    } else {

        $error = "Data turnamen gagal diperbarui.";
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
        Edit Turnamen | Esport Arena
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

    <!-- MAIN -->

    <main class="main">


        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h2>
                    Edit Turnamen
                </h2>

                <p>
                    Ubah data turnamen yang sudah terdaftar.
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



        <!-- FORM EDIT -->

        <div class="content-box">


            <h2>
                Form Edit Turnamen
            </h2>


            <p class="description">
                Perbarui informasi turnamen di bawah ini.
            </p>


            <?php if (isset($error)): ?>

                <div style="
                background:#fee2e2;
                color:#b91c1c;
                padding:12px 15px;
                border-radius:8px;
                margin-bottom:20px;
            ">

                    <?= htmlspecialchars($error); ?>

                </div>

            <?php endif; ?>


            <form method="POST">


                <!-- NAMA TURNAMEN -->

                <div class="form-group">

                    <label>
                        Nama Turnamen
                    </label>

                    <input
                        type="text"
                        name="nama_turnamen"
                        value="<?= htmlspecialchars(
                                    $data['nama_turnamen']
                                ); ?>"
                        required>

                </div>



                <!-- JENIS GAME -->

                <div class="form-group">

                    <label>
                        Jenis Game
                    </label>

                    <select name="jenis_game" required>

                        <option value="">
                            -- Pilih Game --
                        </option>


                        <option value="Mobile Legends"
                            <?= $data['jenis_game'] == 'Mobile Legends'
                                ? 'selected'
                                : ''; ?>>
                            Mobile Legends
                        </option>


                        <option value="Free Fire"
                            <?= $data['jenis_game'] == 'Free Fire'
                                ? 'selected'
                                : ''; ?>>
                            Free Fire
                        </option>


                        <option value="PUBG Mobile"
                            <?= $data['jenis_game'] == 'PUBG Mobile'
                                ? 'selected'
                                : ''; ?>>
                            PUBG Mobile
                        </option>


                        <option value="Valorant"
                            <?= $data['jenis_game'] == 'Valorant'
                                ? 'selected'
                                : ''; ?>>
                            Valorant
                        </option>


                        <option value="EA Sports FC"
                            <?= $data['jenis_game'] == 'EA Sports FC'
                                ? 'selected'
                                : ''; ?>>
                            EA Sports FC
                        </option>

                    </select>

                </div>



                <!-- PENYELENGGARA -->

                <div class="form-group">

                    <label>
                        Penyelenggara
                    </label>

                    <input
                        type="text"
                        name="penyelenggara"
                        value="<?= htmlspecialchars(
                                    $data['penyelenggara']
                                ); ?>"
                        required>

                </div>



                <!-- TANGGAL MULAI -->

                <div class="form-group">

                    <label>
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        name="tanggal_mulai"
                        value="<?= htmlspecialchars(
                                    $data['tanggal_mulai']
                                ); ?>"
                        required>

                </div>



                <!-- TANGGAL SELESAI -->

                <div class="form-group">

                    <label>
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="<?= htmlspecialchars(
                                    $data['tanggal_selesai']
                                ); ?>"
                        required>

                </div>



                <!-- STATUS -->

                <div class="form-group">

                    <label>
                        Status
                    </label>

                    <select name="status" required>


                        <option value="Akan Datang"
                            <?= $data['status'] == 'Akan Datang'
                                ? 'selected'
                                : ''; ?>>
                            Akan Datang
                        </option>


                        <option value="Berlangsung"
                            <?= $data['status'] == 'Berlangsung'
                                ? 'selected'
                                : ''; ?>>
                            Berlangsung
                        </option>


                        <option value="Selesai"
                            <?= $data['status'] == 'Selesai'
                                ? 'selected'
                                : ''; ?>>
                            Selesai
                        </option>


                    </select>

                </div>



                <!-- TOMBOL -->

                <div style="
                display:flex;
                gap:10px;
                margin-top:25px;
            ">


                    <button
                        type="submit"
                        name="update"
                        class="btn btn-primary">

                        💾 Simpan Perubahan

                    </button>


                    <a
                        href="turnamen.php"
                        class="btn"
                        style="
                        background:#e5e7eb;
                        color:#374151;
                    ">

                        Kembali

                    </a>


                </div>


            </form>


        </div>


    </main>


</body>

</html>