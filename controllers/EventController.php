<?php

class EventController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db; // mysqli connection
    }

    public function store()
    {
        $judul     = trim($_POST['judul'] ?? '');
        $lokasi    = trim($_POST['lokasi'] ?? '');
        $tanggal   = $_POST['tanggal'] ?? '';
        $waktu     = $_POST['waktu'] ?? '';
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $poster    = null;
        $errors    = [];

        // === Validasi Form ===
        if (empty($judul))     $errors[] = "Judul event wajib diisi.";
        if (empty($lokasi))    $errors[] = "Lokasi event wajib diisi.";
        if (empty($tanggal))   $errors[] = "Tanggal event wajib diisi.";
        if (empty($waktu))     $errors[] = "Waktu event wajib diisi.";
        if (empty($deskripsi)) $errors[] = "Deskripsi event wajib diisi.";

        // === Validasi dan Upload Poster ===
        if (!empty($_FILES['poster']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $mimeType     = $_FILES['poster']['type'];
            $fileSize     = $_FILES['poster']['size'];

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "Format poster harus JPG, PNG, atau WEBP.";
            } elseif ($fileSize > 2 * 1024 * 1024) {
                $errors[] = "Ukuran poster maksimal 2MB.";
            } else {
                $uploadDir = __DIR__ . '/../assets/upload/events/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename   = uniqid() . '_' . basename($_FILES['poster']['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetPath)) {
                    $poster = 'assets/upload/events/' . $filename;
                } else {
                    $errors[] = "Gagal mengupload poster.";
                }
            }
        }

        // Jika ada error
        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        // Simpan ke database
        $stmt = $this->conn->prepare("
        INSERT INTO events (judul, lokasi, tanggal, waktu, deskripsi, poster)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
        $stmt->bind_param("ssssss", $judul, $lokasi, $tanggal, $waktu, $deskripsi, $poster);

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Event berhasil ditambahkan.";
            header("Location: /SukaInfo_app/dashboard");
        } else {
            $_SESSION['flash_error'] = "Gagal menambahkan event: " . $stmt->error;
            header("Location: /SukaInfo_app/dashboard");
        }

        $stmt->close();
        exit;
    }
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID event tidak ditemukan.";
            header("Location: /SukaInfo_app/events");
            exit;
        }

        $query = $this->conn->query("SELECT * FROM events WHERE id = $id");
        $event = $query->fetch_assoc();

        if (!$event) {
            $_SESSION['flash_error'] = "Data event tidak ditemukan.";
            header("Location: /SukaInfo_app/events");
            exit;
        }

        require __DIR__ . '/../views/admin/pages/event/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['flash_error'] = "Metode tidak valid.";
            header("Location: /SukaInfo_app/events");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['flash_error'] = "ID event tidak ditemukan.";
            header("Location: /SukaInfo_app/events");
            exit;
        }

        $judul = $_POST['judul'] ?? '';
        $tanggal = $_POST['tanggal'] ?? '';
        $lokasi = $_POST['lokasi'] ?? '';
        $deskripsi = $_POST['deskripsi'] ?? '';

        // Validasi sederhana
        if (empty($judul) || empty($tanggal) || empty($lokasi) || empty($deskripsi)) {
            $_SESSION['flash_error'] = "Semua field wajib diisi.";
            header("Location: /SukaInfo_app/events/edit?id=$id");
            exit;
        }

        // Handle upload poster baru jika ada
        $posterPath = null;
        if (!empty($_FILES['poster']['name'])) {
            $uploadDir = 'uploads/posters/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['poster']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetFile)) {
                $posterPath = $targetFile;
            } else {
                $_SESSION['flash_error'] = "Gagal mengupload poster.";
                header("Location: /SukaInfo_app/events/edit?id=$id");
                exit;
            }
        }

        // Siapkan koneksi DB
        require __DIR__ . '/../config/config.php';

        // Update data
        $stmt = $conn->prepare("
        UPDATE events 
        SET judul = ?, tanggal = ?, lokasi = ?, deskripsi = ?" . ($posterPath ? ", poster = ?" : "") . " 
        WHERE id = ?
    ");

        if ($posterPath) {
            $stmt->bind_param('sssssi', $judul, $tanggal, $lokasi, $deskripsi, $posterPath, $id);
        } else {
            $stmt->bind_param('ssssi', $judul, $tanggal, $lokasi, $deskripsi, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Event berhasil diperbarui.";
        } else {
            $_SESSION['flash_error'] = "Gagal memperbarui event.";
        }

        $stmt->close();
        $conn->close();

        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID tidak ditemukan.");
        }

        $stmt = $this->conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();

        if (!$event) {
            die("Event tidak ditemukan.");
        }

        require __DIR__ . '/../views/admin/pages/event/detail.php';
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID event tidak ditemukan.";
            header("Location: /SukaInfo_app/events");
            exit;
        }

        // Ambil data lama untuk menghapus file poster jika ada
        $stmt = $this->conn->prepare("SELECT poster FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();

        if (!$event) {
            $_SESSION['flash_error'] = "Event tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        // Hapus file poster jika ada
        if (!empty($event['poster']) && file_exists($event['poster'])) {
            unlink($event['poster']);
        }

        // Hapus dari database
        $deleteStmt = $this->conn->prepare("DELETE FROM events WHERE id = ?");
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            $_SESSION['flash_success'] = "Event berhasil dihapus.";
        } else {
            $_SESSION['flash_error'] = "Gagal menghapus event.";
        }

        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
}
