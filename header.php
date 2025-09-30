<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Pelindo Arsip document</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ms-auto">
        <?php if (isSuperAdmin()) : ?>
        <li class="nav-item">
          <a class="nav-link" href="super_admin_only.php">Super Admin</a>
        </li>
        <?php endif; ?>
        <li class="nav-item active">
          <a class="nav-link" href="admin_page_upload.php">Upload</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page_read.php">Table</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php" >Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    
</body>
</html>