<?php
// ambil halaman dari query string
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // jumlah data per halaman

$result = getAllPdfFiles($page, $limit);
$files = $result['data'];
$totalPages = $result['totalPages'];
$currentPage = $result['currentPage'];

if (empty($files)) {
    echo "<p>Tidak ada file PDF yang ditemukan.</p>";
    exit;
}

echo "<table border='1' class='table table-bordered'>";
echo "<tr><th>NO</th><th>Judul</th><th>Lokasi</th><th>Tanggal</th><th>Aksi</th></tr>";

$no = ($currentPage - 1) * $limit + 1; // supaya nomor lanjut sesuai halaman
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

// pagination links
echo "<nav class='mt-3'>";
echo "<ul class='pagination'>";

// tombol prev
if ($currentPage > 1) {
    echo "<li class='page-item'><a class='page-link' href='?page=" . ($currentPage - 1) . "'>Prev</a></li>";
}

// nomor halaman
for ($i = 1; $i <= $totalPages; $i++) {
    $active = $i == $currentPage ? "active" : "";
    echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
}

// tombol next
if ($currentPage < $totalPages) {
    echo "<li class='page-item'><a class='page-link' href='?page=" . ($currentPage + 1) . "'>Next</a></li>";
}

echo "</ul>";
echo "</nav>";
?>
