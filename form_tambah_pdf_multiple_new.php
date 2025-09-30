<?php
$nama_bulan = [
    "01" => "Januari",
    "02" => "Februari",
    "03" => "Maret",
    "04" => "April",
    "05" => "Mei",
    "06" => "Juni",
    "07" => "Juli",
    "08" => "Agustus",
    "09" => "September",
    "10" => "Oktober",
    "11" => "November",
    "12" => "Desember"
];
$ayam = $_SESSION['ayam'];
// include "functions.php"; // biar ada fungsi addpdffile

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['pdf'])) {
    $uploadDir = __DIR__ . "/uploads/pdf/"; 
    
    $tanggal = $_POST['tanggal'];
    list($tahun, $bulan, $hari) = explode("-", $tanggal);

    // bikin folder tahun/bulan
    $targetDir = $uploadDir .$ayam. "/" . $tahun . "/" . $nama_bulan[$bulan] . "/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, recursive: true);
    }

    // konversi tanggal ke format kalimat
    $tanggal_format = $hari . " " . $nama_bulan[$bulan] . " " . $tahun;

    // loop semua file
    $totalFiles = count($_FILES['pdf']['name']);
    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = basename($_FILES["pdf"]["name"][$i]);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // hanya boleh pdf
        if ($fileType != "pdf") {
            echo "⚠️ $fileName bukan file PDF.<br>";
            continue;
        }

        if (move_uploaded_file($_FILES["pdf"]["tmp_name"][$i], $targetFile)) {
            $judul = pathinfo($fileName, PATHINFO_FILENAME); // nama file tanpa .pdf
            $lokasi = "/uploads/pdf/" .$ayam. "/" . $tahun . "/" . $nama_bulan[$bulan] . "/" . $fileName;
            
            // simpan ke DB
            if (addpdffile($judul, $lokasi, $tanggal,$_SESSION['user_nama'], $_SESSION['ayam'])) {
                echo "✅ $fileName berhasil diupload dan disimpan.<br>";
            } else {
                echo "❌ Gagal simpan $fileName ke database.<br>";
            }
        } else {
            echo "❌ Gagal upload $fileName.<br>";
        }
    }

    // redirect kalau mau langsung pindah halaman setelah semua selesai
    // header("Location: sukses.php");
    // exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload PDF</title>
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center fw-bold">
            Upload Dokumen PDF
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="pdf" class="form-label">Pilih File PDF</label>
                    <input type="file" id="pdf" name="pdf[]" 
                           accept="application/pdf" 
                           multiple required 
                           class="form-control">
                    <small class="text-muted">* Bisa pilih lebih dari satu file</small>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" required class="form-control">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cloud-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
