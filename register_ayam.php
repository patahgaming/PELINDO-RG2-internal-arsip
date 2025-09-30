<?php
// include "functions.php";
// cek apakah sudah login
if(isLoggedIn()) {
    if (!isSuperAdmin()) {
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = 'admin_page_read.php';</script>";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ayam = htmlspecialchars($_POST['ayam']);
    addAyam($ayam);
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

<div class="container mt-5">
    <h1 class="mb-4">tambah divisi</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="ayam" class="form-label">Divisi</label>
            <input type="text" class="form-control" id="ayam" name="ayam" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>
