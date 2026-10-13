<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

/* =========================
   AMBIL DATA FILTER
========================= */

$game    = isset($_GET['game']) ? trim($_GET['game']) : '';
$status  = isset($_GET['status']) ? trim($_GET['status']) : '';
$tanggal = isset($_GET['tanggal']) ? trim($_GET['tanggal']) : '';

/* =========================
   QUERY DASAR
========================= */

$sql = "SELECT * FROM pertandingan WHERE 1=1";

/* FILTER GAME */
if ($game != '') {
    $game_safe = mysqli_real_escape_string($koneksi, $game);
    $sql .= " AND jenis_game = '$game_safe'";
}

/* FILTER STATUS */
if ($status != '') {
    $status_safe = mysqli_real_escape_string($koneksi, $status);
    $sql .= " AND status = '$status_safe'";
}

/* FILTER TANGGAL */
if ($tanggal != '') {
    $tanggal_safe = mysqli_real_escape_string($koneksi, $tanggal);
    $sql .= " AND tanggal = '$tanggal_safe'";
}

/* URUTKAN BERDASARKAN TANGGAL DAN WAKTU */
$sql .= " ORDER BY tanggal DESC, waktu DESC";

$query = mysqli_query($koneksi, $sql);

/* =========================
   AMBIL DAFTAR GAME
========================= */

$query_game = mysqli_query(
    $koneksi,
    "SELECT DISTINCT jenis_game
     FROM pertandingan
     WHERE jenis_game IS NOT NULL
     AND jenis_game != ''
     ORDER BY jenis_game ASC"
);

/* =========================
   HITUNG JUMLAH DATA
========================= */

$total_data = 0;

if ($query) {
    $total_data = mysqli_num_rows($query);
}

/* NAMA ADMIN */
$nama_admin = $_SESSION['nama_admin'] ?? 'Administrator';

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Laporan Pertandingan | Esport Arena</title>

    <link rel="stylesheet"
        href="assets/css/style.css">

    <style>
        /* =========================
           FILTER LAPORAN
        ========================= */

        .filter-box {
            background: #f8fafc;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 600;
            color: #172033;
            margin-bottom: 15px;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto auto;
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .filter-group label {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            height: 43px;
            padding: 0 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #ffffff;
            color: #172033;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.08);
        }

        .btn-filter {
            height: 43px;
            padding: 0 20px;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: #1d4ed8;
        }

        .btn-reset {
            height: 43px;
            padding: 0 20px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #ffffff;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-reset:hover {
            background: #f1f5f9;
        }

        /* =========================
           HASIL FILTER
        ========================= */

        .result-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px 15px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 6px;
        }

        .result-info strong {
            color: #1d4ed8;
        }

        .result-info span {
            color: #64748b;
            font-size: 14px;
        }

        /* =========================
           STATUS
        ========================= */

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-berlangsung {
            background: #dcfce7;
            color: #15803d;
        }

        .status-selesai {
            background: #e0e7ff;
            color: #4338ca;
        }

        .status-akan-datang {
            background: #fef3c7;
            color: #b45309;
        }

        .status-lain {
            background: #f1f5f9;
            color: #475569;
        }

        /* =========================
           HASIL PERTANDINGAN
        ========================= */

        .hasil-text {
            font-weight: 600;
            color: #172033;
        }

        .tidak-ada {
            color: #94a3b8;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .btn-filter,
            .btn-reset {
                width: 100%;
            }

        }

        @media (max-width: 700px) {

            .filter-form {
                grid-template-columns: 1fr;
            }

            .result-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

        }
    </style>

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

        <a href="data_admin.php">
            Manajemen Admin
        </a>

        <a href="turnamen.php">
            Turnamen
        </a>

        <a href="pertandingan.php">
            Pertandingan
        </a>

        <!-- WASIT TIDAK ACTIVE -->
        <a href="wasit.php">
            Wasit
        </a>

        <!-- PELAPORAN ACTIVE -->
        <a href="laporan_pertandingan.php" class="active">
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
                    Laporan Pertandingan
                </h2>

                <p>
                    Sistem Manajemen Turnamen Esport
                </p>

            </div>

            <div class="profile">

                <div class="avatar">

                    <?= strtoupper(
                        substr($nama_admin, 0, 1)
                    ); ?>

                </div>

                <div>

                    <strong>
                        <?= htmlspecialchars($nama_admin); ?>
                    </strong>

                    <small>
                        Administrator
                    </small>

                </div>

            </div>

        </div>


        <!-- CONTENT -->

        <div class="content-box">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:25px;
            ">

                <div>

                    <h2 style="margin-bottom:5px;">
                        Laporan Pertandingan
                    </h2>

                    <p class="description">
                        Lihat dan filter data pertandingan esport.
                    </p>

                </div>

            </div>


            <!-- FILTER -->

            <div class="filter-box">

                <div class="filter-title">
                    🔎 Filter Laporan
                </div>

                <form method="GET"
                    action="laporan_pertandingan.php">

                    <div class="filter-form">

                        <!-- GAME -->

                        <div class="filter-group">

                            <label for="game">
                                Game
                            </label>

                            <select name="game"
                                id="game">

                                <option value="">
                                    Semua Game
                                </option>

                                <?php
                                if (
                                    $query_game &&
                                    mysqli_num_rows($query_game) > 0
                                ):
                                    while (
                                        $data_game =
                                        mysqli_fetch_assoc($query_game)
                                    ):
                                ?>

                                        <option
                                            value="<?= htmlspecialchars($data_game['jenis_game']); ?>"
                                            <?= ($game == $data_game['jenis_game']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($data_game['jenis_game']); ?>
                                        </option>

                                <?php
                                    endwhile;
                                endif;
                                ?>

                            </select>

                        </div>


                        <!-- STATUS -->

                        <div class="filter-group">

                            <label for="status">
                                Status
                            </label>

                            <select name="status"
                                id="status">

                                <option value="">
                                    Semua Status
                                </option>

                                <option value="Akan Datang"
                                    <?= ($status == 'Akan Datang') ? 'selected' : ''; ?>>
                                    Akan Datang
                                </option>

                                <option value="Berlangsung"
                                    <?= ($status == 'Berlangsung') ? 'selected' : ''; ?>>
                                    Berlangsung
                                </option>

                                <option value="Selesai"
                                    <?= ($status == 'Selesai') ? 'selected' : ''; ?>>
                                    Selesai
                                </option>

                            </select>

                        </div>


                        <!-- TANGGAL -->

                        <div class="filter-group">

                            <label for="tanggal">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                id="tanggal"
                                value="<?= htmlspecialchars($tanggal); ?>">

                        </div>


                        <!-- FILTER -->

                        <button
                            type="submit"
                            class="btn-filter">

                            🔎 Filter

                        </button>


                        <!-- RESET -->

                        <a
                            href="laporan_pertandingan.php"
                            class="btn-reset">

                            ↻ Reset

                        </a>

                    </div>

                </form>

            </div>


            <!-- HASIL FILTER -->

            <div class="result-info">

                <div>

                    Menampilkan

                    <strong>
                        <?= $total_data; ?>
                    </strong>

                    data pertandingan

                </div>

                <span>

                    <?php if (
                        $game != '' ||
                        $status != '' ||
                        $tanggal != ''
                    ): ?>

                        Filter sedang digunakan

                    <?php else: ?>

                        Semua pertandingan

                    <?php endif; ?>

                </span>

            </div>


            <!-- TABEL -->

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Game</th>
                            <th>Nama Pertandingan</th>
                            <th>Tim A</th>
                            <th>Tim B</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Hasil</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        if (
                            $query &&
                            mysqli_num_rows($query) > 0
                        ):

                            while (
                                $data =
                                mysqli_fetch_assoc($query)
                            ):

                                $status_class = 'status-lain';

                                if (
                                    $data['status'] ==
                                    'Berlangsung'
                                ) {

                                    $status_class =
                                        'status-berlangsung';
                                } elseif (
                                    $data['status'] ==
                                    'Selesai'
                                ) {

                                    $status_class =
                                        'status-selesai';
                                } elseif (
                                    $data['status'] ==
                                    'Akan Datang'
                                ) {

                                    $status_class =
                                        'status-akan-datang';
                                }

                        ?>

                                <tr>

                                    <td>
                                        <?= $no++; ?>
                                    </td>

                                    <td>

                                        <strong>
                                            <?= htmlspecialchars(
                                                $data['jenis_game']
                                            ); ?>
                                        </strong>

                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $data['nama_pertandingan']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $data['tim_a']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $data['tim_b']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd-m-Y',
                                            strtotime($data['tanggal'])
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $data['waktu']
                                        ); ?>
                                    </td>

                                    <td>

                                        <span class="status-badge <?= $status_class; ?>">

                                            <?= htmlspecialchars(
                                                $data['status']
                                            ); ?>

                                        </span>

                                    </td>

                                    <td>

                                        <?php if (
                                            !empty($data['hasil'])
                                        ): ?>

                                            <span class="hasil-text">

                                                <?= htmlspecialchars(
                                                    $data['hasil']
                                                ); ?>

                                            </span>

                                        <?php else: ?>

                                            <span class="tidak-ada">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php

                            endwhile;

                        else:

                            ?>

                            <tr>

                                <td
                                    colspan="9"
                                    style="
                                    text-align:center;
                                    padding:50px;
                                    color:#64748b;
                                ">

                                    📊 Tidak ada data pertandingan

                                    <br>

                                    <span style="
                                    display:inline-block;
                                    margin-top:8px;
                                ">

                                        Coba ubah filter yang digunakan.

                                    </span>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</body>

</html>