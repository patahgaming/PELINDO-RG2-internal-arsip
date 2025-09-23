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
// include "functions.php"; // biar ada fungsi addpdffile

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['pdf'])) {
    $uploadDir = __DIR__ . "/uploads/pdf/"; 
    
    $tanggal = $_POST['tanggal'];
    list($tahun, $bulan, $hari) = explode("-", $tanggal);
    $fileName = basename($_FILES["pdf"]["name"]);
    $targetFile = $uploadDir . $tahun . "/" . $nama_bulan[$bulan] . "/" . $fileName;
    if (!is_dir($uploadDir . $tahun . "/" . $nama_bulan[$bulan] . "/")) {
        mkdir($uploadDir . $tahun . "/" . $nama_bulan[$bulan] . "/", 0777, true); // bikin folder kalau belum ada
    }
    

// Pisah jadi array [tahun, bulan, hari]
list($tahun, $bulan, $hari) = explode("-", $tanggal);

// Konversi bulan angka jadi nama bulan

// Bentuk kalimat
$tanggal_format = $hari . " " . $nama_bulan[$bulan] . " " . $tahun;


    // cek hanya PDF
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if ($fileType != "pdf") {
        echo "Hanya file PDF yang diperbolehkan.";
        exit;
    }

    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $targetFile)) {
        $judul = pathinfo($fileName, PATHINFO_FILENAME); // nama file tanpa .pdf
        $lokasi = "/uploads/pdf/" . $tahun . "/" . $nama_bulan[$bulan] . "/" . $fileName; // path relatif untuk disimpan
        $tanggal = $tanggal ?: date("Y-m-d");

        if (addpdffile($judul, $lokasi, $tanggal)) {
                header("Location: sukses.php");
                exit;
        } else {
            echo "Gagal simpan ke database.";
        }
    } else {
        echo "Gagal upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload PDF</title>

</head>
<body>
    <div class="container mt-5">
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="pdf" class="form-label">Pilih File PDF:</label>
            <input type="file" id="pdf" name="pdf" accept="application/pdf" required class="form-control">
        </div>
        <div>
            <label for="tanggal" class="form-label">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    </div>
</body>
</html>