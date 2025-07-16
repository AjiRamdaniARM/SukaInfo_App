<?php

class RekomendasiController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db; // mysqli connection
    }

    public function create()
    {

        // Kirim ke view
        require __DIR__ . '/../views/admin/pages/rekomendasi/create.php';
    }
    public function store()
    {
        // Validasi method POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        // Ambil dan filter input
        $nama_tempat = trim($_POST['nama_tempat'] ?? '');
        $kategori    = trim($_POST['kategori'] ?? '');
        $lokasi      = trim($_POST['lokasi'] ?? '');
        $tanggal     = $_POST['tanggal'] ?? null;
        $deskripsi   = $_POST['deskripsi'] ?? '';
        $status      = $_POST['status'] ?? 'draft';

        // Validasi data wajib
        if (empty($nama_tempat) || empty($kategori) || empty($lokasi) || empty($tanggal) || empty($deskripsi)) {
            $_SESSION['flash_error'] = "Semua field bertanda * wajib diisi.";
            header('Location: /SukaInfo_app/createRekomendasi');
            exit;
        }

        // Handle upload gambar (jika ada)
        $posterPath = null;
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/rekomendasi/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $ext = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
            $newName = uniqid('poster_', true) . '.' . $ext;
            $destination = $uploadDir . $newName;

            if (move_uploaded_file($_FILES['poster']['tmp_name'], $destination)) {
                $posterPath = $destination;
            }
        }

        // Simpan ke database
        $stmt = $this->conn->prepare("INSERT INTO tempats (nama_tempat, kategori, lokasi, tanggal, deskripsi, status, poster) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            $_SESSION['flash_error'] = "Gagal menyiapkan query: " . $this->conn->error;
            header('Location: /SukaInfo_app/dashboard');
            exit;
        }

        $stmt->bind_param("sssssss", $nama_tempat, $kategori, $lokasi, $tanggal, $deskripsi, $status, $posterPath);

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Rekomendasi tempat berhasil disimpan.";
            header('Location: /SukaInfo_app/dashboard');
            exit;
        } else {
            $_SESSION['flash_error'] = "Gagal menyimpan data: " . $stmt->error;
            header('Location: /SukaInfo_app/dashboard');
            exit;
        }
    }

    public function edit()
    {
        // Ambil ID dari parameter GET
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID tempat tidak ditemukan.";
            header("Location: /SukaInfo_app/admin"); // Redirect ke dashboard
            exit;
        }

        // Query untuk mengambil data tempat
        $stmt = $this->conn->prepare("SELECT * FROM tempats WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash_error'] = "Data tempat tidak ditemukan.";
            header("Location: /SukaInfo_app/admin");
            exit;
        }

        // Ambil data tempat
        $tempat = $result->fetch_assoc();

        // Kirim data ke view edit
        require __DIR__ . '/../views/admin/pages/rekomendasi/edit.php';
    }
    public function update()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID tidak ditemukan.";
            header("Location: /SukaInfo_app/admin");
            exit;
        }

        // Ambil input dari form
        $nama_tempat = $_POST['nama_tempat'] ?? '';
        $kategori    = $_POST['kategori'] ?? '';
        $lokasi      = $_POST['lokasi'] ?? '';
        $tanggal     = $_POST['tanggal'] ?? '';
        $deskripsi   = $_POST['deskripsi'] ?? '';
        $status      = $_POST['status'] ?? 'draft';

        // Validasi input sederhana
        if (empty($nama_tempat) || empty($kategori) || empty($lokasi) || empty($tanggal) || empty($deskripsi)) {
            $_SESSION['flash_error'] = "Semua field wajib diisi.";
            header("Location: /SukaInfo_app/rekomendasi/edit?id=$id");
            exit;
        }

        // Cek apakah ada file yang di-upload
        $posterPath = null;
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['poster']['tmp_name'];
            $fileName    = uniqid() . '-' . basename($_FILES['poster']['name']);
            $uploadDir   = 'uploads/posters/';
            $destPath    = $uploadDir . $fileName;

            // Buat folder jika belum ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $posterPath = $destPath;
            } else {
                $_SESSION['flash_error'] = "Gagal mengunggah poster.";
                header("Location: /SukaInfo_app/dashboard");
                exit;
            }
        }

        // Update query
        if ($posterPath) {
            $stmt = $this->conn->prepare("UPDATE tempats SET nama_tempat=?, kategori=?, lokasi=?, tanggal=?, deskripsi=?, status=?, poster=? WHERE id=?");
            $stmt->bind_param("sssssssi", $nama_tempat, $kategori, $lokasi, $tanggal, $deskripsi, $status, $posterPath, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE tempats SET nama_tempat=?, kategori=?, lokasi=?, tanggal=?, deskripsi=?, status=? WHERE id=?");
            $stmt->bind_param("ssssssi", $nama_tempat, $kategori, $lokasi, $tanggal, $deskripsi, $status, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Data rekomendasi berhasil diperbarui.";
        } else {
            $_SESSION['flash_error'] = "Gagal memperbarui data: " . $stmt->error;
        }

        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        // Cek apakah data ada dan ambil file poster
        $check = $this->conn->prepare("SELECT poster FROM tempats WHERE id = ?");
        $check->bind_param("i", $id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash_error'] = "Data rekomendasi tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        $data = $result->fetch_assoc();
        $posterPath = $data['poster'];

        // Hapus file poster jika ada
        if (!empty($posterPath) && file_exists($posterPath)) {
            unlink($posterPath);
        }

        // Hapus data dari database
        $stmt = $this->conn->prepare("DELETE FROM tempats WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Data rekomendasi berhasil dihapus.";
        } else {
            $_SESSION['flash_error'] = "Gagal menghapus data.";
        }

        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
}
