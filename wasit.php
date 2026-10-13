<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

/* AMBIL DATA WASIT */
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM wasit ORDER BY id_wasit DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Wasit | Esport Arena</title>

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


        <a href="pertandingan.php">
            Pertandingan
        </a>


        <a href="wasit.php"
            class="active">
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
                    Wasit
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
                        Data Wasit
                    </h2>

                    <p class="description">
                        Kelola data wasit pertandingan esport.
                    </p>

                </div>


                <a
                    href="tambah_wasit.php"
                    class="btn btn-primary">

                    + Tambah Wasit

                </a>

            </div>



            <!-- TABLE -->

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama Wasit</th>

                            <th>Game</th>

                            <th>No. HP</th>

                            <th>Email</th>

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
                                                $data['nama_wasit']
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
                                            $data['no_hp']
                                        ); ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $data['email']
                                        ); ?>
                                    </td>


                                    <td>

                                        <div class="action-group">


                                            <a
                                                href="edit_wasit.php?id=<?= $data['id_wasit']; ?>"
                                                class="btn btn-edit">
                                                Edit
                                            </a>


                                            <a
                                                href="hapus_wasit.php?id=<?= $data['id_wasit']; ?>"
                                                class="btn btn-delete"
                                                onclick="return confirm('Yakin ingin menghapus data wasit ini?');">
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
                                    colspan="6"
                                    class="empty-data">

                                    Belum ada data wasit.


                                    <br>


                                    <a
                                        href="tambah_wasit.php"
                                        class="empty-link">
                                        + Tambahkan wasit pertama
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