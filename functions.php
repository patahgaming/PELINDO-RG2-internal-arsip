<?php
session_start();
function connectDB() {
    $host = "localhost";
    $user = "root";   
    $pass = "";        
    $dbname = "pelindo_arsip";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    return $conn;
}

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
function login(string $username, string $password): bool {
    $conn = connectDB();
    if (!$conn) return false;

    $stmt = $conn->prepare("SELECT id, pass, role FROM user WHERE nama = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    if ($user && password_verify($password, $user['pass'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nama'] = $username;
        $_SESSION['role'] = $user['role'];
        // var_dump($_SESSION);
        // exit;
        return true;
    }
    return false;
}

function register(string $nama, string $pass): bool {
    $conn = connectDB();
    if (!$conn) return false;

    // cek apakah username sudah ada
    $stmt = $conn->prepare("SELECT id FROM user WHERE nama = ?");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return false; // username sudah ada
    }

    $stmt->close();

    // kalau belum ada → insert
    $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO user (nama, pass) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $hashedPassword);
    $ok = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $ok;
}
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}
function isAdmin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'bulu_bulul';
}
function ifnotAdminRedirect() {
    if (!isLoggedIn() || !isAdmin()) {
        header("Location: index.php");
        exit;
    }
}
function logout() {
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

function addpdffile(string $judul, string $lokasi, string $tanggal): bool {
    $conn = connectDB();
    if (!$conn) return false;

    $stmt = $conn->prepare("INSERT INTO pdf (judul, lokasi, tanggal) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $judul, $lokasi , $tanggal);
    $ok = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $ok;
}
function getAllPdfFiles(): array {
    $conn = connectDB();
    if (!$conn) return [];

    $result = $conn->query("SELECT * FROM pdf ORDER BY tanggal DESC");
    $files = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }
        $result->free();
    }

    $conn->close();
    return $files;
}
function getAllPdfFilesByMonthYear(int $month, int $year): array {
    $conn = connectDB();
    if (!$conn) return [];

    $stmt = $conn->prepare("SELECT * FROM pdf WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ? ORDER BY tanggal DESC");
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    $files = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }
        $result->free();
    }

    $stmt->close();
    $conn->close();
    return $files;
}
function getFilteredPdfFiles(?int $month = null, ?int $year = null, ?string $judul = null, ?string $tags = null): array {
    $conn = connectDB();
    if (!$conn) return [];

    $query = "SELECT * FROM pdf WHERE 1=1";
    $params = [];
    $types  = "";

    if ($month !== null && $month > 0) {
        $query .= " AND MONTH(tanggal) = ?";
        $params[] = $month;
        $types   .= "i";
    }

    if ($year !== null && $year > 0) {
        $query .= " AND YEAR(tanggal) = ?";
        $params[] = $year;
        $types   .= "i";
    }

    if (!empty($judul)) {
        $query .= " AND judul LIKE ?";
        $params[] = "%" . $judul . "%";
        $types   .= "s";
    }

    if (!empty($tags)) {
        $query .= " AND tags LIKE ?";
        $params[] = "%" . $tags . "%";
        $types   .= "s";
    }

    $query .= " ORDER BY tanggal DESC";

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $files = [];
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }

    $stmt->close();
    $conn->close();
    return $files;
}

function getPdfById(int $id): ?array {
    $conn = connectDB();
    if (!$conn) return null;

    $stmt = $conn->prepare("SELECT * FROM pdf WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $file = null;
    if ($result) {
        $file = $result->fetch_assoc();
        $result->free();
    }

    $stmt->close();
    $conn->close();
    return $file;
}
function deletePdfById(int $id): bool {
    $conn = connectDB();
    if (!$conn) return false;

    // Ambil lokasi file dulu
    $file = getPdfById($id);
    if ($file && file_exists(__DIR__ . $file['lokasi'])) {
        unlink(__DIR__ . $file['lokasi']); // Hapus file fisik
    }

    $stmt = $conn->prepare("DELETE FROM pdf WHERE id = ?");
    $stmt->bind_param("i", $id);
    $ok = $stmt->execute();

    $stmt->close();
    $conn->close();
    return $ok;
}
function pdfDetails(int $id): ?array {
    return getPdfById($id);
}
function getRole() {
    if (isset($_SESSION['role'])) {
        return $_SESSION['role'];
    }
    return null;
}
?>
