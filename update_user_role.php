<?php
include "functions.php";
// cek apakah sudah login
if (isLoggedIn()) {
    if (!isSuperAdmin()) {
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = 'admin_page_read.php';</script>";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
$user_id =$_POST['user_id'] ?? null;
$user =$_POST['user_id'] ?? null;

if (!$user) {
    echo "<script>alert('User tidak ditemukan.'); window.location.href = 'super_admin_only.php';</script>";
    exit;
}
if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $user_id = intval($_POST['user_id']);
    $new_role = $_POST['new_role'];
    if (update_user_role($user_id, $new_role)) {
        echo "<script>alert('Role user berhasil diubah.'); window.location.href = 'super_admin_only.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah role user.'); window.location.href = 'super_admin_only.php';</script>";
    }
}
?>