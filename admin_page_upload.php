<?php
include "functions.php";
// cek apakah sudah login
if(isLoggedIn()) {
    if (!isAdmin() && !isSuperAdmin()) {
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = 'admin_page_read.php';</script>";
        exit;
    }
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
        <?php include "form_tambah_pdf_multiple_new.php"; ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>
