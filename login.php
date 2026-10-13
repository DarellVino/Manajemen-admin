<?php

session_start();

if (isset($_SESSION['id_admin'])) {
    header("Location: dashboard.php");
    exit;
}

$pesan = $_SESSION['pesan'] ?? "";

unset($_SESSION['pesan']);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <<title>
        Login Admin | Tournament Management
        </title>

        <link rel="stylesheet"
            href="assets/css/style.css">

</head>

<body class="login-page">

    <div class="login-container">

        <div class="login-card">

            <div class="login-logo">
                ⚡
            </div>

            <h1>
                TOURNAMENT MANAGEMENT
            </h1>
            <p class="login-subtitle">
                Login Administrator
            </p>

            <?php if ($pesan != "") { ?>

                <div class="alert">

                    <?= htmlspecialchars($pesan); ?>

                </div>

            <?php } ?>

            <form action="cek_login.php"
                method="POST">

                <div class="form-group">

                    <label>
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        required>

                </div>

                <div class="form-group">

                    <label>
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>

                </div>

                <button
                    type="submit"
                    name="login"
                    class="btn btn-primary btn-full">

                    Login

                </button>

            </form>

            <a href="index.php"
                class="back-link">

                ← Kembali ke halaman utama

            </a>

        </div>

    </div>

</body>

</html>