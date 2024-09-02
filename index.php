<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    <title>Login</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="login/login-admin.php" method="post">
                <h1>Login Admin</h1>
                <span>Masukkan email dan password untuk masuk sebagai admin</span>
                <input type="email" placeholder="Email.." required name="email">
                <input type="password" placeholder="Password.." required name="password">
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="login/login-karyawan.php" method="post">
                <h1>Login Karyawan</h1>
                <span>Masukkan email dan password untuk masuk sebagai karyawan</span>
                <input type="email" placeholder="Email.." required name="email">
                <input type="password"placeholder="Password.." required name="password">
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h2>Selamat Datang Admin!</h2>
                    <p>Klik disini untuk masuk sebagai Karyawan</p>
                    <button class="hidden" id="login">Login</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h2>Selamat Datang Karyawan!</h2>
                    <p>Klik disini untuk masuk sebagai Admin</p>
                    <button class="hidden" id="register">Login</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
    <script>
        const container = document.getElementById('container');
        const registerBtn = document.getElementById('register');
        const loginBtn = document.getElementById('login');

        registerBtn.addEventListener('click', () => {
            container.classList.add("active");
        });

        loginBtn.addEventListener('click', () => {
            container.classList.remove("active");
        });
    </script>

    <?php
    if (isset($_SESSION['message']) && isset($_SESSION['type'])) {
        echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: '" .
            $_SESSION['message'] .
            "',
                    icon: '" .
            $_SESSION['type'] .
            "',
                    confirmButtonText: 'OK'
                });
            </script>";
        unset($_SESSION['message']);
        unset($_SESSION['type']);
    }
    ?>
</body>

</html>
