<?php
include "functions.php";

// cek login
if (!isLoggedIn()) {
    header("Location: index.php");
    exit;
}

// hanya super admin
if (!isSuperAdmin()) {
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = 'admin_page_read.php';</script>";
    exit;
}

// ambil user_id
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;

if (!$user_id) {
    echo "<script>alert('User tidak ditemukan.'); window.location.href = 'super_admin_only.php';</script>";
    exit;
}

// proses hapus
if (deleteUser($user_id)) {
    echo "<script>alert('User berhasil dihapus.'); window.location.href = 'super_admin_only.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus user.'); window.location.href = 'super_admin_only.php';</script>";
}
