<?php
include "functions.php";
// cek apakah sudah login
if(isLoggedIn()) {
    if (!isSuperAdmin()) {
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = 'admin_page_read.php';</script>";
        exit;
    }
}
include "header.php";
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
        
    </div>
    <div class="container mt-5">
        <?php include "register_ayam.php"; ?>
    </div>
<div>
    <?php 
    $users = getAllUsers();
    if (!empty($users)) : 
?>
<table class="table table-bordered table-striped align-middle">
    <thead class="table-primary text-center">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Divisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['nama']) ?></td>
            <td>
                <?php 
                    if ($user['role'] === 'bulu_bulul') {
                        echo 'Admin';
                    } elseif ($user['role'] === 'super_bulu_bulul') {
                        echo 'Super Admin';
                    } else {
                        echo htmlspecialchars($user['role']); // fallback kalau ada role lain
                    }
                ?>
            </td>
            <td><?= htmlspecialchars($user['ayam']) ?></td>
            <td>
                <form method="POST" action="update_user_role.php" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                    <select name="new_role" class="form-select form-select-sm w-auto" required>
                        <option value="" disabled selected>Pilih role</option>
                        <option value="bulu_bulul">Admin</option>
                        <option value="super_bulu_bulul">Super Admin</option>
                        <option value="user">User</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                </form>
                <form action="delete_user.php" method="POST" class="d-flex align-items-center gap-2"
      onsubmit="return confirm('Yakin ingin menghapus user ini?');">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
    else: 
?>
    <div class="alert alert-warning">Tidak ada data pengguna.</div>
<?php 
    endif;
?>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>