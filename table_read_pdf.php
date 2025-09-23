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


include "the_table.php";


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
