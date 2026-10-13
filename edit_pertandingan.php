<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";


/* CEK ID */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: pertandingan.php");
    exit;
}

$id = intval($_GET['id']);


/* AMBIL DATA */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM pertandingan WHERE id_pertandingan = $id"
);

if (!$query || mysqli_num_rows($query) == 0) {

    echo "<script>
        alert('Data pertandingan tidak ditemukan!');
        window.location='pertandingan.php';
    </script>";

    exit;
}

$data = mysqli_fetch_assoc($query);


/* PROSES UPDATE */

if (isset($_POST['update'])) {

    $jenis_game = mysqli_real_escape_string(
        $koneksi,
        $_POST['jenis_game']
    );

    $nama_pertandingan = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_pertandingan']
    );

    $tim_a = mysqli_real_escape_string(
        $koneksi,
        $_POST['tim_a']
    );

    $tim_b = mysqli_real_escape_string(
        $koneksi,
        $_POST['tim_b']
    );

    $tanggal = mysqli_real_escape_string(
        $koneksi,
        $_POST['tanggal']
    );

    $waktu = mysqli_real_escape_string(
        $koneksi,
        $_POST['waktu']
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );

    $hasil = mysqli_real_escape_string(
        $koneksi,
        $_POST['hasil']
    );


    $update = mysqli_query(
        $koneksi,
        "UPDATE pertandingan SET
            jenis_game = '$jenis_game',
            nama_pertandingan = '$nama_pertandingan',
            tim_a = '$tim_a',
            tim_b = '$tim_b',
            tanggal = '$tanggal',
            waktu = '$waktu',
            status = '$status',
            hasil = '$hasil'
        WHERE id_pertandingan = $id"
    );


    if ($update) {

        echo "<script>
            alert('Data pertandingan berhasil diperbarui!');
            window.location='pertandingan.php';
        </script>";

        exit;
    } else {

        $error = "Data gagal diperbarui: " . mysqli_error($koneksi);
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
        Edit Pertandingan | Esport Arena
    </title>

    <link rel="stylesheet"
        href="assets/css/style.css">


    <style>
        /* =========================
           FORM EDIT PERTANDINGAN
        ========================= */

        .form-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 30px;
            max-width: 1000px;
        }


        .form-header {
            margin-bottom: 30px;
        }


        .form-header h2 {
            font-size: 25px;
            color: #172033;
            margin-bottom: 7px;
        }


        .form-header p {
            color: #6b7280;
            font-size: 14px;
        }


        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }


        .form-group {
            margin-bottom: 0;
        }


        .form-group.full {
            grid-column: 1 / -1;
        }


        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }


        .form-control {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            color: #1f2937;
            background: #ffffff;
            outline: none;
            transition: 0.2s;
        }


        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }


        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }


        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid #e5e7eb;
        }


        .btn-update {
            display: inline-block;
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }


        .btn-update:hover {
            background: #1d4ed8;
        }


        .btn-back {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 8px;
            background: #e5e7eb;
            color: #374151;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }


        .btn-back:hover {
            background: #d1d5db;
        }


        .alert-error {
            margin-bottom: 25px;
            padding: 13px 15px;
            border-radius: 8px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: 14px;
        }


        @media (max-width: 700px) {

            .form-grid {
                grid-template-columns: 1fr;
            }


            .form-group.full {
                grid-column: auto;
            }


            .form-card {
                padding: 20px;
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
                    Edit Pertandingan
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



        <!-- FORM -->

        <div class="form-card">


            <div class="form-header">

                <h2>
                    ✏️ Edit Data Pertandingan
                </h2>


                <p>
                    Ubah informasi pertandingan yang sudah tersimpan.
                </p>

            </div>



            <?php if (isset($error)): ?>

                <div class="alert-error">

                    <?= htmlspecialchars($error); ?>

                </div>

            <?php endif; ?>



            <form method="POST">


                <div class="form-grid">


                    <!-- GAME -->

                    <div class="form-group">

                        <label>
                            Jenis Game
                        </label>


                        <select
                            name="jenis_game"
                            class="form-control"
                            required>

                            <option value="Mobile Legends"
                                <?= $data['jenis_game'] == 'Mobile Legends' ? 'selected' : ''; ?>>
                                Mobile Legends
                            </option>


                            <option value="PUBG Mobile"
                                <?= $data['jenis_game'] == 'PUBG Mobile' ? 'selected' : ''; ?>>
                                PUBG Mobile
                            </option>


                            <option value="Free Fire"
                                <?= $data['jenis_game'] == 'Free Fire' ? 'selected' : ''; ?>>
                                Free Fire
                            </option>


                            <option value="Valorant"
                                <?= $data['jenis_game'] == 'Valorant' ? 'selected' : ''; ?>>
                                Valorant
                            </option>


                            <option value="Dota 2"
                                <?= $data['jenis_game'] == 'Dota 2' ? 'selected' : ''; ?>>
                                Dota 2
                            </option>

                        </select>

                    </div>



                    <!-- NAMA -->

                    <div class="form-group">

                        <label>
                            Nama Pertandingan
                        </label>


                        <input
                            type="text"
                            name="nama_pertandingan"
                            class="form-control"
                            value="<?= htmlspecialchars($data['nama_pertandingan']); ?>"
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
                            value="<?= htmlspecialchars($data['tim_a']); ?>"
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
                            value="<?= htmlspecialchars($data['tim_b']); ?>"
                            required>

                    </div>



                    <!-- TANGGAL -->

                    <div class="form-group">

                        <label>
                            Tanggal Pertandingan
                        </label>


                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="<?= htmlspecialchars($data['tanggal']); ?>"
                            required>

                    </div>



                    <!-- WAKTU -->

                    <div class="form-group">

                        <label>
                            Waktu Pertandingan
                        </label>


                        <input
                            type="time"
                            name="waktu"
                            class="form-control"
                            value="<?= htmlspecialchars($data['waktu']); ?>"
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


                            <option value="Belum Dimulai"
                                <?= $data['status'] == 'Belum Dimulai' ? 'selected' : ''; ?>>
                                Belum Dimulai
                            </option>


                            <option value="Berlangsung"
                                <?= $data['status'] == 'Berlangsung' ? 'selected' : ''; ?>>
                                Berlangsung
                            </option>


                            <option value="Selesai"
                                <?= $data['status'] == 'Selesai' ? 'selected' : ''; ?>>
                                Selesai
                            </option>


                        </select>

                    </div>



                    <!-- HASIL -->

                    <div class="form-group">

                        <label>
                            Hasil Pertandingan
                        </label>


                        <input
                            type="text"
                            name="hasil"
                            class="form-control"
                            value="<?= htmlspecialchars($data['hasil'] ?? ''); ?>"
                            placeholder="Contoh: 2 - 1">

                    </div>


                </div>



                <!-- BUTTON -->

                <div class="form-actions">


                    <button
                        type="submit"
                        name="update"
                        class="btn-update">

                        💾 Simpan Perubahan

                    </button>


                    <a
                        href="pertandingan.php"
                        class="btn-back">

                        ← Kembali

                    </a>


                </div>


            </form>


        </div>


    </main>


</body>

</html>