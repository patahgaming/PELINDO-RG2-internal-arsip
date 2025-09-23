<?php
// Ambil filter dari form (default bulan & tahun sekarang)
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year  = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Ambil data PDF sesuai filter
$files = getAllPdfFilesByMonthYear($month, $year);

?>

<!-- Form filter -->
<form method="get" class="mb-3">
    <label for="month">Bulan:</label>
    <select name="month" id="month">
        <?php
        $nama_bulan = [
            1=>"Januari", 2=>"Februari", 3=>"Maret", 4=>"April", 5=>"Mei", 6=>"Juni",
            7=>"Juli", 8=>"Agustus", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Desember"
        ];
        foreach ($nama_bulan as $num => $nama) {
            $selected = ($num == $month) ? "selected" : "";
            echo "<option value='$num' $selected>$nama</option>";
        }
        ?>
    </select>

    <label for="year">Tahun:</label>
    <select name="year" id="year">
        <?php
        $currentYear = date('Y');
        for ($y = $currentYear; $y >= 2000; $y--) {
            $selected = ($y == $year) ? "selected" : "";
            echo "<option value='$y' $selected>$y</option>";
        }
        ?>
    </select>

    <button type="submit" class="btn btn-primary">Filter</button>
</form>

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
