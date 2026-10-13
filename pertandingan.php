<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM pertandingan
     ORDER BY tanggal DESC, waktu DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pertandingan | Esport Arena</title>

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


        <a href="turnamen.php">
            Turnamen
        </a>


        <a href="pertandingan.php"
            class="active">
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
                    Pertandingan
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



        <!-- CONTENT -->

        <div class="content-box">


            <div class="page-header">

                <div>

                    <h2>
                        Data Pertandingan
                    </h2>

                    <p class="description">
                        Kelola jadwal dan hasil pertandingan esport.
                    </p>

                </div>


                <a href="tambah_pertandingan.php"
                    class="btn btn-primary">

                    + Tambah Pertandingan

                </a>

            </div>



            <!-- TABLE -->

            <div class="table-container">

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
                                        <?= htmlspecialchars(
                                            $data['jenis_game']
                                        ); ?>
                                    </td>


                                    <td>

                                        <strong>
                                            <?= htmlspecialchars(
                                                $data['nama_pertandingan']
                                            ); ?>
                                        </strong>

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
                                        <?= htmlspecialchars(
                                            $data['tanggal']
                                        ); ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $data['waktu']
                                        ); ?>
                                    </td>


                                    <td>

                                        <?php

                                        if ($data['status'] == 'Berlangsung'):

                                        ?>

                                            <span class="status-badge status-process">
                                                Berlangsung
                                            </span>


                                        <?php

                                        elseif ($data['status'] == 'Selesai'):

                                        ?>

                                            <span class="status-badge status-success">
                                                Selesai
                                            </span>


                                        <?php else: ?>

                                            <span class="status-badge status-pending">
                                                Belum Dimulai
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>

                                        <?php

                                        if (!empty($data['hasil'])) {

                                            echo htmlspecialchars(
                                                $data['hasil']
                                            );
                                        } else {

                                            echo '-';
                                        }

                                        ?>

                                    </td>


                                    <td>

                                        <div class="action-group">


                                            <a
                                                href="edit_pertandingan.php?id=<?= $data['id_pertandingan']; ?>"
                                                class="btn btn-edit">
                                                Edit
                                            </a>


                                            <a
                                                href="hapus_pertandingan.php?id=<?= $data['id_pertandingan']; ?>"
                                                class="btn btn-delete"
                                                onclick="return confirm('Yakin ingin menghapus pertandingan ini?');">
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
                                    colspan="10"
                                    class="empty-data">

                                    Belum ada data pertandingan.

                                    <br>

                                    <a
                                        href="tambah_pertandingan.php"
                                        class="empty-link">
                                        Tambahkan pertandingan pertama
                                    </a>

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