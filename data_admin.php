<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM admin ORDER BY id_admin DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manajemen Admin | Esport Arena</title>

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


    <a href="data_admin.php"
       class="active">
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


    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h2>
                Manajemen Admin
            </h2>

            <p>
                Kelola akun administrator sistem
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
                    Data Admin
                </h2>

                <p class="description">
                    Kelola data administrator sistem.
                </p>

            </div>


            <a href="tambah_admin.php"
               class="btn btn-primary">

                + Tambah Admin

            </a>

        </div>



        <!-- TABLE -->

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Username</th>

                        <th>Nama Admin</th>

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
                                $data['username']
                            ); ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $data['nama_admin']
                            ); ?>
                        </td>


                        <td>

                            <div class="action-group">

                                <a
                                    href="edit_admin.php?id=<?= $data['id_admin']; ?>"
                                    class="btn btn-edit"
                                >
                                    Edit
                                </a>


                                <a
                                    href="hapus_admin.php?id=<?= $data['id_admin']; ?>"
                                    class="btn btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus admin ini?');"
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
                            colspan="4"
                            class="empty-data">

                            Belum ada data admin.

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