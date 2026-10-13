<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$query = mysqli_query($koneksi, "SELECT * FROM pertandingan ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pertandingan - Esport Arena</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #172b4d;
        }

        .content {
            margin-left: 370px;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
        }

        .header p {
            margin-top: 8px;
            color: #60758f;
        }

        .btn-tambah {
            background: #2864e8;
            color: white;
            padding: 14px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(40, 100, 232, 0.2);
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f5f7fa;
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #dce3ec;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #edf0f4;
        }

        tr:hover {
            background: #fafbfc;
        }

        .edit {
            color: #2864e8;
            text-decoration: none;
            font-weight: bold;
            margin-right: 20px;
        }

        .hapus {
            color: #e53935;
            text-decoration: none;
            font-weight: bold;
        }

        .kosong {
            text-align: center;
            color: #777;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="content">

    <div class="header">
        <div>
            <h1>Data Pertandingan</h1>
            <p>Kelola data pertandingan esport.</p>
        </div>

        <a href="tambah_pertandingan.php" class="btn-tambah">
            + Tambah Pertandingan
        </a>
    </div>

    <div class="card">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Game</th>
                    <th>Nama Pertandingan</th>
                    <th>Tim A</th>
                    <th>Tim B</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $no = 1;

            if (mysqli_num_rows($query) > 0) {

                while ($data = mysqli_fetch_assoc($query)) {
            ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>
                        <?= htmlspecialchars($data['jenis_game']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['nama_pertandingan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['tim_a']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['tim_b']); ?>
                    </td>

                    <td>
                        <?= date('d-m-Y', strtotime($data['tanggal'])); ?>
                    </td>

                    <td>

                        <a
                            href="edit_pertandingan.php?id=<?= $data['id_pertandingan']; ?>"
                            class="edit"
                        >
                            Edit
                        </a>

                        <a
                            href="hapus_pertandingan.php?id=<?= $data['id_pertandingan']; ?>"
                            class="hapus"
                            onclick="return confirm('Yakin ingin menghapus pertandingan ini?')"
                        >
                            Hapus
                        </a>

                    </td>

                </tr>

            <?php
                }

            } else {
            ?>

                <tr>
                    <td colspan="7" class="kosong">
                        Belum ada data pertandingan.
                    </td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>