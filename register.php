<?php
include 'db/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Default role adalah user

    // Cek apakah username atau email sudah ada
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Registrasi Gagal',
                text: 'Username atau email sudah terdaftar!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
        </script>";
    } else {
        // Query tambah user
        $query = "INSERT INTO users (username, email, password, role) 
                  VALUES ('$username', '$email', '$password', '$role')";
        
        if (mysqli_query($koneksi, $query)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil',
                    text: 'Anda akan dialihkan ke halaman login',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = 'login.php';
                    }
                });
            });
            </script>";
        } else {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Registrasi Gagal',
                    text: 'Terjadi kesalahan: " . mysqli_error($koneksi) . "',
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
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Concept - Bootstrap 4 Admin Dashboard Template</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
      rel="stylesheet"
      href="./assets/vendor/bootstrap/css/bootstrap.min.css"
    />
    <link
      href="./assets/vendor/fonts/circular-std/style.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/libs/css/style.css" />
    <link
      rel="stylesheet"
      href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css"
    />
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
    <form method="POST" class="splash-container">
      <div class="card">
        <div class="card-header">
          <h3 class="mb-1">Registrations Form</h3>
          <p>Please enter your user information.</p>
        </div>
        <div class="card-body">
          <div class="form-group">
            <input
              class="form-control form-control-lg"
              type="text"
              name="username"
              placeholder="Achmad Sofyan"
              autocomplete="off"
            />
          </div>
          <div class="form-group">
            <input
              class="form-control form-control-lg"
              type="email"
              name="email"
              placeholder="E-mail"
              autocomplete="off"
            />
          </div>
          <div class="form-group">
            <input
              class="form-control form-control-lg"
              type="password"
              name="password"
              required
              placeholder="Password"
            />
          </div>
          <div class="form-group pt-2">
            <button class="btn btn-block btn-primary" type="submit">
              Register My Account
            </button>
          </div>
        <div class="card-footer bg-white">
          <p>
            Already Account? <a href="/login.php" class="text-secondary">Login Here.</a>
          </p>
        </div>
      </div>
    </form>
  </body>
</html>