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

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center fw-bold">
            Tambah Divisi
        </div>
        <div class="card-body p-4">
            <form method="POST" action="">
                <!-- Input Divisi -->
                <div class="mb-4">
                    <label for="ayam" class="form-label fw-semibold">
                        Nama Divisi
                    </label>
                    <input type="text" class="form-control" id="ayam" name="ayam" required>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>
