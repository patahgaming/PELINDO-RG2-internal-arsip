<?php
if (empty($files)) {
    echo "<p>Tidak ada file PDF yang ditemukan.</p>";
    // exit;
}
if(!empty($files)) {
echo "<table border='1' class='table table-bordered'>";
echo "<tr><th>NO</th><th>Judul</th><th>Lokasi</th><th>Tanggal</th><th>Aksi</th></tr>";
$no = 1;
foreach ($files as $file) {
    echo "<tr>";
    echo "<td>" . $no . "</td>";
    echo "<td>" . htmlspecialchars($file['judul']) . "</td>";
    echo "<td><a href='" . htmlspecialchars($file['lokasi']) . "' target='_blank' class='btn btn-info'>Lihat PDF</a></td>";
    echo "<td>" . htmlspecialchars($file['tanggal']) . "</td>";
    echo "<td><a href='delete_pdf.php?id=" . urlencode($file['id']) . "' class='btn btn-danger'>Hapus</a></td>";
    echo "</tr>";
    $no++;
}
echo "</table>";
}
?>