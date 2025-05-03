<?php
session_start();
include 'db/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah email dan password ada di POST
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);
        $password = $_POST['password'];

        // Query cari user berdasarkan email
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($koneksi, $query);
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];
            
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: 'Tunggu Sebentar',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    // jika role sama dengan admin maka ke halaman dashboard
                    // jika role sama dengan user maka ke halaman index
                    didClose: () => {
                        window.location.href = '".$user['role']."' === 'admin' ? 'dashboard.php' : 'index.php';
                    }
                });
            });
            </script>";
        } else {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: 'Email atau password salah!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
            </script>";
        }
    } else {
        // Jika email atau password tidak ada
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: 'Harap isi email dan password!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
        </script>";
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="../index.html"><img class="logo-img"
                        src="./assets/images/logo.png" alt="logo"></a><span class="splash-description">Please enter
                    your user information.</span></div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="email" name="email" placeholder="Username"
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="password" name="password"
                            placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span
                                class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Create An Account</a>
                </div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>