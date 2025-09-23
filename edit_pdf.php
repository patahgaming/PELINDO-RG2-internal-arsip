<?php
include "functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

</head>
<?php include "header.php"; ?>
<body>
    <div class="container mt-5">
    <h2>Edit PDF</h2>
    <form method="POST" action="proses_edit_pdf.php?id=<?= $_GET['id']; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="pdf" class="form-label">Pilih File PDF:</label>
            <input type="file" id="pdf" name="pdf" accept="application/pdf" required class="form-control">
        </div>
        <div>
            <label for="tanggal" class="form-label">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>