<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";


/* =========================================
   JUMLAH PERTANDINGAN
========================================= */

$total_pertandingan = 0;

$query_pertandingan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM pertandingan"
);

if ($query_pertandingan) {

    $data_pertandingan = mysqli_fetch_assoc(
        $query_pertandingan
    );

    $total_pertandingan = $data_pertandingan['total'] ?? 0;
}


/* =========================================
   PERTANDINGAN BERLANGSUNG
========================================= */

$berlangsung = 0;

$query_berlangsung = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM pertandingan
     WHERE status='Berlangsung'"
);

if ($query_berlangsung) {

    $data_berlangsung = mysqli_fetch_assoc(
        $query_berlangsung
    );

    $berlangsung = $data_berlangsung['total'] ?? 0;
}


/* =========================================
   PERTANDINGAN SELESAI
========================================= */

$selesai = 0;

$query_selesai = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM pertandingan
     WHERE status='Selesai'"
);

if ($query_selesai) {

    $data_selesai = mysqli_fetch_assoc(
        $query_selesai
    );

    $selesai = $data_selesai['total'] ?? 0;
}


/* =========================================
   JUMLAH ADMIN
========================================= */

$total_admin = 0;

$query_admin = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM admin"
);

if ($query_admin) {

    $data_admin = mysqli_fetch_assoc(
        $query_admin
    );

    $total_admin = $data_admin['total'] ?? 0;
}

?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Dashboard | Esport Arena
    </title>

    <link rel="stylesheet"
        href="assets/css/style.css">

</head>


<body class="dashboard-page">


    <!-- =========================================
         SIDEBAR
    ========================================== -->

    <aside class="sidebar">

        <div class="logo">
            TOURNAMENT <span>MANAGEMENT</span>
        </div>


        <div class="menu-title">
            MENU UTAMA
        </div>


        <a href="dashboard.php"
            class="active">

            Dashboard

        </a>


        <a href="data_admin.php">

            Manajemen Admin

        </a>


        <a href="turnamen.php">

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



    <!-- =========================================
         MAIN
    ========================================== -->

    <main class="main">


        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h2>
                    Dashboard
                </h2>

                <p>
                    Sistem Manajemen Turnamen Esport
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



        <!-- =========================================
             WELCOME
        ========================================== -->

        <div class="welcome-box">

            <div>

                <h2>

                    Selamat Datang,
                    <?= htmlspecialchars(
                        $_SESSION['nama_admin']
                            ?? 'Administrator'
                    ); ?>!

                </h2>


                <p>

                    Kelola data turnamen dan pertandingan
                    melalui dashboard administrator.

                </p>

            </div>

        </div>



        <!-- =========================================
             STATISTIK
        ========================================== -->

        <div class="stats-grid">


            <!-- TOTAL PERTANDINGAN -->

            <div class="stat-card">

                <div class="stat-icon">
                    ⚔
                </div>

                <div class="stat-info">

                    <span>
                        Total Pertandingan
                    </span>

                    <h2>
                        <?= $total_pertandingan; ?>
                    </h2>

                </div>

            </div>



            <!-- BERLANGSUNG -->

            <div class="stat-card">

                <div class="stat-icon">
                    ▶
                </div>

                <div class="stat-info">

                    <span>
                        Sedang Berlangsung
                    </span>

                    <h2>
                        <?= $berlangsung; ?>
                    </h2>

                </div>

            </div>



            <!-- SELESAI -->

            <div class="stat-card">

                <div class="stat-icon">
                    ✓
                </div>

                <div class="stat-info">

                    <span>
                        Pertandingan Selesai
                    </span>

                    <h2>
                        <?= $selesai; ?>
                    </h2>

                </div>

            </div>



            <!-- ADMIN -->

            <div class="stat-card">

                <div class="stat-icon">
                    👤
                </div>

                <div class="stat-info">

                    <span>
                        Total Admin
                    </span>

                    <h2>
                        <?= $total_admin; ?>
                    </h2>

                </div>

            </div>


        </div>



        <!-- =========================================
             MENU CEPAT
        ========================================== -->

        <div class="content-box">


            <h2>
                Menu Cepat
            </h2>


            <p class="description">

                Pilih menu yang ingin dikelola.

            </p>



            <div class="quick-menu">


                <!-- PERTANDINGAN -->

                <a href="pertandingan.php"
                    class="quick-card">

                    <div>
                        ⚔
                    </div>

                    <h3>
                        Pertandingan
                    </h3>

                    <p>
                        Kelola jadwal pertandingan esports.
                    </p>

                </a>



                <!-- ADMIN -->

                <a href="data_admin.php"
                    class="quick-card">

                    <div>
                        👤
                    </div>

                    <h3>
                        Manajemen Admin
                    </h3>

                    <p>
                        Kelola akun administrator.
                    </p>

                </a>



                <!-- TURNAMEN -->

                <a href="turnamen.php"
                    class="quick-card">

                    <div>
                        🏆
                    </div>

                    <h3>
                        Turnamen
                    </h3>

                    <p>
                        Kelola data turnamen esport.
                    </p>

                </a>



                <!-- WASIT -->

                <a href="wasit.php"
                    class="quick-card">

                    <div>
                        ⚖
                    </div>

                    <h3>
                        Wasit
                    </h3>

                    <p>
                        Kelola data wasit pertandingan.
                    </p>

                </a>



                <!-- PELAPORAN -->

                <a href="laporan_pertandingan.php"
                    class="quick-card">

                    <div>
                        📊
                    </div>

                    <h3>
                        Pelaporan
                    </h3>

                    <p>
                        Lihat laporan pertandingan.
                    </p>

                </a>


            </div>

        </div>


    </main>


</body>

</html>