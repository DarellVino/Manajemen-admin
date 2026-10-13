<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {

    $username   = trim($_POST['username'] ?? '');
    $nama_admin = trim($_POST['nama_admin'] ?? '');
    $password   = trim($_POST['password'] ?? '');

    // Validasi
    if ($username == "" || $nama_admin == "" || $password == "") {

        $error = "Semua data harus diisi.";

    } else {

        // Cek username
        $username_aman = mysqli_real_escape_string(
            $koneksi,
            $username
        );

        $cek = mysqli_query(
            $koneksi,
            "SELECT id_admin
             FROM admin
             WHERE username='$username_aman'"
        );

        if (!$cek) {

            $error = "Terjadi kesalahan database: " . mysqli_error($koneksi);

        } elseif (mysqli_num_rows($cek) > 0) {

            $error = "Username sudah digunakan.";

        } else {

            
            $password_md5 = md5($password);

            $username_db = mysqli_real_escape_string(
                $koneksi,
                $username
            );

            $nama_db = mysqli_real_escape_string(
                $koneksi,
                $nama_admin
            );

            $query = mysqli_query(
                $koneksi,
                "INSERT INTO admin
                (username, password, nama_admin)
                VALUES
                ('$username_db', '$password_md5', '$nama_db')"
            );

            if ($query) {

                // Berhasil disimpan
                header("Location: data_admin.php");
                exit;

            } else {

                $error = "Data admin gagal disimpan: "
                       . mysqli_error($koneksi);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Admin | Tournament Management</title>

    <link rel="stylesheet"
          href="assets/css/style.css?v=3">

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

    <a href="data_admin.php" class="active">
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


<!-- MAIN -->

<main class="main">

    <div class="topbar">

        <div>

            <h2>
                Tambah Admin
            </h2>

            <p>
                Tambahkan akun administrator baru.
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
                        $_SESSION['nama_admin'] ?? 'Administrator'
                    ); ?>
                </strong>

                <small>
                    Administrator
                </small>

            </div>

        </div>

    </div>


    <!-- CONTENT -->

    <div class="content-box">

        <div class="page-header">

            <div>

                <h2>
                    Form Tambah Admin
                </h2>

                <p class="description">
                    Isi data administrator dengan lengkap.
                </p>

            </div>

        </div>


        <!-- PESAN ERROR -->

        <?php if ($error != ""): ?>

            <div class="alert-error">

                <?= htmlspecialchars($error); ?>

            </div>

        <?php endif; ?>


        <!-- FORM -->

        <form method="POST">

            <div class="form-group">

                <label>
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    placeholder="Masukkan username"
                    value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Nama Admin
                </label>

                <input
                    type="text"
                    name="nama_admin"
                    placeholder="Masukkan nama admin"
                    value="<?= htmlspecialchars($_POST['nama_admin'] ?? ''); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-primary">

                    Simpan Admin

                </button>

                <a
                    href="data_admin.php"
                    class="btn btn-back">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</main>

</body>

</html>