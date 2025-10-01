<!-- /**
 * Pelindo Arsip Functions
 * 
 * This file contains utility functions for user authentication, authorization, 
 * database connection, PDF file management, and division (ayam) management.
 * 
 * Functions:
 * - connectDB(): Establishes a MySQL database connection.
 * - sanitizeInput($data): Sanitizes user input.
 * - login($username, $password): Authenticates user and starts session.
 * - register($nama, $pass, $ayam): Registers a new user.
 * - isLoggedIn(): Checks if a user is logged in.
 * - isAdmin(): Checks if the logged-in user is an admin.
 * - isSuperAdmin(): Checks if the logged-in user is a super admin.
 * - isUser(): Checks if the logged-in user is a regular user.
 * - ifnotAdminRedirect(): Redirects to index.php if not admin.
 * - logout(): Logs out the user and destroys session.
 * - getAllUsers(): Retrieves all users from the database.
 * - update_user_role($user_id, $new_role): Updates a user's role.
 * - getUserById($id): Retrieves user details by ID.
 * - deleteUser($id): Deletes a user by ID.
 * - addAyam($nama): Adds a new division (ayam).
 * - addpdffile($judul, $lokasi, $tanggal, $nama, $ayam): Adds a new PDF file record.
 * - getAllPdfFiles($page, $limit): Retrieves paginated PDF files.
 * - getAllAyam(): Retrieves all division names.
 * - getAllPdfFilesBetter($month, $year, $keyword, $ayam, $role): Retrieves filtered PDF files.
 * - getFilteredPdfFiles($month, $year, $judul, $tags): Retrieves PDF files with advanced filters.
 * - getPdfById($id): Retrieves PDF file details by ID.
 * - deletePdfById($id): Deletes a PDF file by ID and removes the physical file.
 * - pdfDetails($id): Alias for getPdfById().
 * - getRole(): Gets the current user's role from session.
 * 
 * Security:
 * - Uses prepared statements to prevent SQL injection.
 * - Passwords are hashed using bcrypt.
 * - Input is sanitized before processing.
 * 
 * Session:
 * - Session is started for authentication and authorization.
 * 
 * Usage:
 * Include this file in your PHP project to use the provided functions for user and PDF management.
 */ -->
<?php
echo '<meta name="robots" content="noindex, nofollow, noarchive">';
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

function sanitizeInput($data): string {
    return htmlspecialchars(strip_tags(trim($data)));
}
function login(string $username, string $password): bool {
    $conn = connectDB();
    if (!$conn) return false;

    $stmt = $conn->prepare("SELECT id, pass, role, ayam FROM user WHERE nama = ?");
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
        $_SESSION['ayam'] = $user['ayam'];
        // untuk debug
        // var_dump($_SESSION);
        // exit;
        return true;
    }
    return false;
}

function register(?string $nama, ?string $pass, ?string $ayam = "unset"): bool {
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
    $stmt = $conn->prepare("INSERT INTO user (nama, pass, ayam) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $hashedPassword, $ayam);
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
function isSuperAdmin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'super_bulu_bulul';
}
function isUser(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
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
function getAllUsers(): array {
    $conn = connectDB();
    if (!$conn) return [];

    $stmt = $conn->prepare("SELECT id, nama, role, ayam FROM user");
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $users;
}
function update_user_role(string $user_id, string $new_role): bool {
    $conn = connectDB();
    if (!$conn) return false;

    $stmt = $conn->prepare("UPDATE user SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $user_id);
    $ok = $stmt->execute();

    $stmt->close();
    $conn->close();
    return $ok;
}
function getUserById(int $id): ?array {
    $conn = connectDB();
    if (!$conn) return null;

    $stmt = $conn->prepare("SELECT id, nama, role, ayam FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = null;
    if ($result) {
        $user = $result->fetch_assoc();
        $result->free();
    }

    $stmt->close();
    $conn->close();
    return $user;
}
function deleteUser(int $id): bool {
    $conn = connectDB();
    if (!$conn) return false;

    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $ok = $stmt->execute();

    $stmt->close();
    $conn->close();
    return $ok;
}
/**
 * Menambahkan data ayam ke dalam database jika belum ada.
 *
 * Fungsi ini akan memeriksa apakah ayam dengan nama yang diberikan sudah ada di tabel 'ayam'.
 * Jika belum ada, maka data ayam akan ditambahkan ke database.
 *
 * @param string $nama Nama ayam yang akan ditambahkan.
 * @return bool True jika penambahan berhasil, false jika gagal atau ayam sudah ada.
 */
function addAyam(string $nama): bool {
    $conn = connectDB();
    if (!$conn) return false;

    // cek apakah ayam sudah ada
    $stmt = $conn->prepare("SELECT id FROM ayam WHERE nama = ?");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return false; // ayam sudah ada
    }

    $stmt->close();

    // kalau belum ada → insert
    $stmt = $conn->prepare("INSERT INTO ayam (nama) VALUES (?)");
    $stmt->bind_param("s", $nama);
    $ok = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $ok;
}
/**
 * Inserts a new PDF file record into the database.
 *
 * @param string $judul   The title of the PDF.
 * @param string $lokasi  The location or path of the PDF file.
 * @param string $tanggal The date associated with the PDF.
 * @param string $nama    The name of the user uploading the PDF.
 * @param string $ayam    An optional utility field (default: "utilitas").
 *
 * @return bool Returns true on successful insertion, false otherwise.
 */
function addpdffile(string $judul, string $lokasi, string $tanggal, string $nama, string $ayam = "utilitas"): bool {
    $conn = connectDB();
    if (!$conn) return false;

    $stmt = $conn->prepare("INSERT INTO pdf (judul, lokasi, tanggal, upload_by, ayam) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $judul, $lokasi , $tanggal, $nama, $ayam);
    $ok = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $ok;
}
function getAllPdfFiles(int $page = 1, int $limit = 10): array {
    $conn = connectDB();
    if (!$conn) return [];

    // hitung offset
    $offset = ($page - 1) * $limit;

    // ambil data dengan limit
    $stmt = $conn->prepare("SELECT * FROM pdf ORDER BY tanggal DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $files = [];
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
    $stmt->close();

    // ambil total data untuk hitung total halaman
    $totalResult = $conn->query("SELECT COUNT(*) as total FROM pdf");
    $totalRow = $totalResult->fetch_assoc();
    $total = (int)$totalRow['total'];
    $totalPages = ceil($total / $limit);

    $conn->close();

    return [
        "data" => $files,
        "total" => $total,
        "totalPages" => $totalPages,
        "currentPage" => $page,
        "limit" => $limit
    ];
}
/**
 * Retrieves all 'nama' values from the 'ayam' table in the database.
 *
 * @return array An array of 'nama' strings from the 'ayam' table.
 */
function getAllAyam(): array {
    $conn = connectDB();
    if (!$conn) return [];

    $stmt = $conn->prepare("SELECT nama FROM `ayam`");
    $stmt->execute();
    $result = $stmt->get_result();

    $ayams = [];
    while ($row = $result->fetch_assoc()) {
        $ayams[] = $row['nama']; // ✅ ambil sesuai kolom SELECT
    }
    $stmt->close();
    $conn->close();
    return $ayams;
}
/**
 * Retrieves all PDF files from the database with optional filtering.
 *
 * Filters can be applied based on month, year, keyword in the title, division (ayam), and user role.
 * - If $month is provided and not zero, filters by the given month.
 * - If $year is provided and not zero, filters by the given year.
 * - If $keyword is provided and not empty, filters by titles containing the keyword.
 * - If $role is 'bulu_bulul' or 'user', and $ayam is provided, filters by the given division.
 * - Results are ordered by the 'tanggal' field in descending order.
 *
 * @param int|null    $month   The month to filter by (1-12). Default is 0 (no filter).
 * @param int|null    $year    The year to filter by. Default is 0 (no filter).
 * @param string      $keyword The keyword to search in the title. Default is empty string.
 * @param string|null $ayam    The division to filter by. Default is null.
 * @param string|null $role    The user role for access control. Default is null.
 *
 * @return array Returns an array of associative arrays representing PDF files.
 */
function getAllPdfFilesBetter(
    ?int $month = 0, 
    ?int $year = 0, 
    string $keyword = "", 
    ?string $ayam = null,
    ?string $role = null
): array {
    // var_dump($month, $year, $keyword, $ayam, $role);
    $conn = connectDB();
    if (!$conn) return [];
    // var_dump($month, $year, $keyword, $ayam, $role);
    // exit;
    
    $sql = "SELECT * FROM pdf WHERE 1=1"; 
    
    $params = [];
    $types  = "";

    // filter bulan
    if ($month != 0) {
        $sql .= " AND MONTH(tanggal) = ?";
        $types .= "i";
        $params[] = $month;
    }

    // filter tahun
    if ($year != 0) {
        $sql .= " AND YEAR(tanggal) = ?";
        $types .= "i";
        $params[] = $year;
    }

    // filter judul
    if (!empty($keyword)) {
        $sql .= " AND judul LIKE ?";
        $types .= "s";
        $params[] = "%{$keyword}%";
    }
    // filter divisi (ayam)
    
    if ($role === 'bulu_bulul' || $role === 'user') {
        // var_dump($role, $ayam);
        // exit;
        // kalau bukan super admin, paksa ayam sesuai divisi user   
            if (!empty($ayam)) {
        $sql .= " AND ayam = ?";
        $types .= "s";
        $params[] = $ayam;
    }
    }


    $sql .= " ORDER BY tanggal DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

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
