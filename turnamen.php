<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

/* Ambil semua data turnamen */
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM turnamen ORDER BY id_turnamen DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Turnamen | Esport Arena</title>

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


    <a href="data_admin.php">
        Manajemen Admin
    </a>


    <a href="turnamen.php"
       class="active">
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


    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h2>
                Turnamen
            </h2>

            <p>
                Kelola data turnamen esport
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



    <!-- CONTENT -->

    <div class="content-box">


        <div class="page-header">

            <div>

                <h2>
                    Daftar Turnamen
                </h2>

                <p class="description">
                    Data turnamen yang terdaftar dalam sistem.
                </p>

            </div>


            <a href="tambah_turnamen.php"
               class="btn btn-primary">

                + Tambah Turnamen

            </a>

        </div>



        <!-- TABLE -->

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Nama Turnamen</th>

                        <th>Jenis Game</th>

                        <th>Penyelenggara</th>

                        <th>Mulai</th>

                        <th>Selesai</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($query) > 0):

                    while ($data = mysqli_fetch_assoc($query)):

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>


                        <td>

                            <strong>
                                <?= htmlspecialchars(
                                    $data['nama_turnamen']
                                ); ?>
                            </strong>

                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $data['jenis_game']
                            ); ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $data['penyelenggara']
                            ); ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $data['tanggal_mulai']
                            ); ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $data['tanggal_selesai']
                            ); ?>
                        </td>


                        <td>

                            <?php if ($data['status'] == 'Akan Datang'): ?>

                                <span class="status-badge status-info">
                                    Akan Datang
                                </span>


                            <?php elseif ($data['status'] == 'Berlangsung'): ?>

                                <span class="status-badge status-success">
                                    Berlangsung
                                </span>


                            <?php else: ?>

                                <span class="status-badge status-pending">
                                    Selesai
                                </span>

                            <?php endif; ?>

                        </td>


                        <td>

                            <div class="action-group">

                                <a
                                    href="edit_turnamen.php?id=<?= $data['id_turnamen']; ?>"
                                    class="btn btn-edit"
                                >
                                    Edit
                                </a>


                                <a
                                    href="hapus_turnamen.php?id=<?= $data['id_turnamen']; ?>"
                                    class="btn btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus turnamen ini?');"
                                >
                                    Hapus
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php

                    endwhile;

                else:

                ?>

                    <tr>

                        <td
                            colspan="8"
                            class="empty-data">

                            Belum ada data turnamen.

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