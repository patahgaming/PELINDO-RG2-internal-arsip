<?php
include "functions.php";
if (isLoggedIn()) {
    header("Location: admin_page_upload.php");
    exit;
}
$error = ""; // buat nampung pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $pass = htmlspecialchars($_POST['pass']);
    
    if (login($nama, $pass)) {
        header("Location: admin_page_upload.php");
        exit;
    } else {
        $error = "Nama atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Website PHP + Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="text-center mb-4 fw-bold">Login</h2>

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger text-center"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                        <label for="nama">Nama</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required>
                        <label for="pass">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">Login</button>
                </form>

                <!-- <p class="text-center mt-4 mb-0 text-muted">
                    Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar</a>
                </p> -->
            </div>
        </div>
    </div>
</div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html>
