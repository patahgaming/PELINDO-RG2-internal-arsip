<?php
include "functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $pass = htmlspecialchars($_POST['pass']);
    $ayam = htmlspecialchars($_POST['ayam']);
    register($nama, $pass, $ayam);
    header("Location: index.php"); // refresh biar form gak ke-submit ulang
    exit;
}

// $users = getUsers();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Website PHP + Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="text-center mb-4 fw-bold">Register</h2>

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger text-center"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
                        <label for="nama">Nama Lengkap</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required>
                        <label for="pass">Password</label>
                    </div>

                    <div class="form-floating mb-4">
                        <select class="form-select" id="ayam" name="ayam" required>
                            <option value="" disabled selected>Pilih Divisi</option>
                            <?php foreach (getAllAyam() as $a): ?>
                                <option value="<?= htmlspecialchars($a) ?>"><?= htmlspecialchars($a) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="ayam">Divisi</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">Register</button>
                </form>

                <p class="text-center mt-4 mb-0 text-muted">
                    Sudah punya akun? <a href="login_user.php" class="text-decoration-none">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <a href="index.php" class="">kembali</a>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>
