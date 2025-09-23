<?php
// Ambil filter dari form (default bulan & tahun sekarang)
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year  = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Ambil data PDF sesuai filter
$files = getAllPdfFilesByMonthYear($month, $year);

?>

<!-- Form filter -->
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
                </div>
                <div class="col-md-6">
                    <label for="year" class="form-label">Tahun</label>
                    <select name="year" id="year" class="form-select">
                        <?php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= 2000; $y--) {
                            $selected = ($y == $year) ? "selected" : "";
                            echo "<option value='$y' $selected>$y</option>";
                        }
                        ?>
                    </select>
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
