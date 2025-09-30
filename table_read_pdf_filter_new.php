<?php
// Ambil filter dari form (default bulan & tahun sekarang)
$month = 0;
$year  = 0;
if (isset($_GET['month'])) {
    if ($_GET['month'] == 0) {
        $month = null;
    }
    else {
        $month = (int)$_GET['month'];
    }
}
if (isset($_GET['year'])) {
    if ($_GET['year'] == 0) {
        $year = null;
        exit;
    }
    else {
        $year = (int)$_GET['year'];
    }
}
// $month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
// $year  = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
// var_dump($keywords);
// var_dump($month);
// var_dump($year);
// exit;
// Ambil data PDF sesuai filter
$files = getAllPdfFilesBetter($month, $year , $keywords, $_SESSION['ayam'], $_SESSION['role']);

?>

<!-- Form filter -->
<!-- buat tahun dan bulan defaultnya null -->
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center fw-bold">
            Filter Dokumen
        </div>
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="month" class="form-label">Bulan</label>
                    <select name="month" id="month" class="form-select">
                        <option value="">-- Semua Bulan --</option>
                        <?php
                        $nama_bulan = [
                            1=>"Januari", 2=>"Februari", 3=>"Maret", 4=>"April", 5=>"Mei", 6=>"Juni",
                            7=>"Juli", 8=>"Agustus", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Desember"
                        ];
                        foreach ($nama_bulan as $num => $nama) {
                            $selected = ($month !== null && $num == $month) ? "selected" : "";
                            echo "<option value='$num' $selected>$nama</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="year" class="form-label">Tahun</label>
                    <select name="year" id="year" class="form-select">
                        <option value="">-- Semua Tahun --</option>
                        <?php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= 2000; $y--) {
                            $selected = ($year !== null && $y == $year) ? "selected" : "";
                            echo "<option value='$y' $selected>$y</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <label for="keywords" class="form-label">Kata Kunci (Judul)</label>
                    <input type="text" id="keywords" name="keywords" 
                           value="<?= htmlspecialchars($keywords) ?>" 
                           placeholder="Masukkan kata kunci judul..." 
                           class="form-control">
                </div>
                <div class="col-12 d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
include "the_table.php"
?>
<!-- <?php
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
?> -->