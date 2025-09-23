<?php
include "functions.php";

$id = intval($_GET['id']);
if (deletePdfById($id)) {
    echo "<script>alert('File berhasil dihapus.'); window.location.href = 'admin_page.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus file.'); window.location.href = 'admin_page.php';</script>";
}
?>
