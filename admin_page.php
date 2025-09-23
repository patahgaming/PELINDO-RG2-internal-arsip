<?php
include "functions.php";
// cek apakah sudah login
if (ifnotAdminRedirect()) {
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include "header.php"; ?>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-success">
            <h3>selamat datang, <?= htmlspecialchars($_SESSION['user_nama']); ?></h3>
        </div>
        <?php include "form_tambah_pdf_multiple.php"; ?>
    </div>
    <div class="container mt-5">
        <?php include "tabel_read_pdf.php"; ?>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>
