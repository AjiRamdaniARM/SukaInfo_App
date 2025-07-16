<?php

class LowonganController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db; // mysqli connection
    }

    public function create()
    {
        // Tampilkan halaman form create lowongan
        require __DIR__ . '/../views/admin/pages/jobs/create.php';
    }

    public function update()
    {
        session_start();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID lowongan tidak ditemukan.";
            header("Location: /SukaInfo_app/jobs");
            exit;
        }

        // Ambil data dari POST
        $judul             = trim($_POST['judul'] ?? '');
        $perusahaan        = trim($_POST['perusahaan'] ?? '');
        $lokasi            = trim($_POST['lokasi'] ?? '');
        $jenis_pekerjaan   = $_POST['jenis_pekerjaan'] ?? '';
        $gaji              = trim($_POST['gaji'] ?? '');
        $tanggal_berakhir  = $_POST['tanggal_berakhir'] ?? '';
        $deskripsi         = trim($_POST['deskripsi'] ?? '');

        $errors = [];

        // Validasi
        if (empty($judul)) $errors[] = "Judul lowongan wajib diisi.";
        if (empty($perusahaan)) $errors[] = "Nama perusahaan wajib diisi.";
        if (empty($lokasi)) $errors[] = "Lokasi wajib diisi.";
        if (!in_array($jenis_pekerjaan, ['fulltime', 'parttime', 'magang', 'freelance'])) {
            $errors[] = "Jenis pekerjaan tidak valid.";
        }
        if (empty($tanggal_berakhir)) {
            $errors[] = "Tanggal penutupan wajib diisi.";
        }

        // Upload poster (jika ada)
        $poster = null;
        if (!empty($_FILES['poster']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $mimeType = $_FILES['poster']['type'];
            $fileSize = $_FILES['poster']['size'];

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "Format poster tidak valid.";
            } elseif ($fileSize > 2 * 1024 * 1024) {
                $errors[] = "Ukuran poster maksimal 2MB.";
            } else {
                $uploadDir = __DIR__ . '/../assets/upload/jobs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename = uniqid() . '_' . basename($_FILES['poster']['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetPath)) {
                    $poster = 'assets/upload/jobs/' . $filename;
                } else {
                    $errors[] = "Gagal mengupload poster.";
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode("<br>", $errors);
            header("Location: /SukaInfo_app/editJobs?id=$id");
            exit;
        }

        // Update ke database
        if ($poster) {
            $stmt = $this->conn->prepare("
            UPDATE lowongans SET 
                judul = ?, perusahaan = ?, lokasi = ?, jenis_pekerjaan = ?, gaji = ?, 
                tanggal_berakhir = ?, poster = ?, deskripsi = ?
            WHERE id = ?
        ");
            $stmt->bind_param("ssssssssi", $judul, $perusahaan, $lokasi, $jenis_pekerjaan, $gaji, $tanggal_berakhir, $poster, $deskripsi, $id);
        } else {
            $stmt = $this->conn->prepare("
            UPDATE lowongans SET 
                judul = ?, perusahaan = ?, lokasi = ?, jenis_pekerjaan = ?, gaji = ?, 
                tanggal_berakhir = ?, deskripsi = ?
            WHERE id = ?
        ");
            $stmt->bind_param("sssssssi", $judul, $perusahaan, $lokasi, $jenis_pekerjaan, $gaji, $tanggal_berakhir, $deskripsi, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Lowongan berhasil diperbarui.";
        } else {
            $_SESSION['flash_error'] = "Gagal memperbarui lowongan: " . $stmt->error;
        }

        $stmt->close();
        header("Location: /SukaInfo_app/dashboard");
        exit;
    }

    public function edit()
    {
        // Ambil ID dari URL
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID lowongan tidak ditemukan.";
            header("Location: /SukaInfo_app/jobs"); // Arahkan kembali ke list lowongan
            exit;
        }

        // Ambil data lowongan dari database
        $stmt = $this->conn->prepare("SELECT * FROM lowongans WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $lowongan = $result->fetch_assoc();

        if (!$lowongan) {
            $_SESSION['flash_error'] = "Data lowongan tidak ditemukan.";
            header("Location: /SukaInfo_app/jobs");
            exit;
        }

        // Tampilkan halaman edit
        require __DIR__ . '/../views/admin/pages/jobs/edit.php';
    }


    public function store()
    {


        // Ambil data dari POST
        $judul             = trim($_POST['judul'] ?? '');
        $perusahaan        = trim($_POST['perusahaan'] ?? '');
        $lokasi            = trim($_POST['lokasi'] ?? '');
        $jenis_pekerjaan   = $_POST['jenis_pekerjaan'] ?? '';
        $gaji              = trim($_POST['gaji'] ?? '');
        $tanggal_berakhir  = $_POST['tanggal_berakhir'] ?? '';
        $deskripsi         = trim($_POST['deskripsi'] ?? '');

        $errors = [];

        // Validasi
        if (empty($judul)) $errors[] = "Judul wajib diisi.";
        if (empty($perusahaan)) $errors[] = "Nama perusahaan wajib diisi.";
        if (empty($lokasi)) $errors[] = "Lokasi wajib diisi.";
        if (!in_array($jenis_pekerjaan, ['fulltime', 'parttime', 'magang', 'freelance'])) {
            $errors[] = "Jenis pekerjaan tidak valid.";
        }
        if (empty($tanggal_berakhir)) $errors[] = "Tanggal penutupan wajib diisi.";
        if (empty($deskripsi)) $errors[] = "Deskripsi wajib diisi.";

        // Upload Poster (jika ada)
        $poster = null;
        if (!empty($_FILES['poster']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $mimeType     = $_FILES['poster']['type'];
            $fileSize     = $_FILES['poster']['size'];

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "Format poster harus JPG, PNG, atau WEBP.";
            } elseif ($fileSize > 2 * 1024 * 1024) {
                $errors[] = "Ukuran poster maksimal 2MB.";
            } else {
                $uploadDir = __DIR__ . '/../assets/upload/jobs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename = uniqid() . '_' . basename($_FILES['poster']['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetPath)) {
                    $poster = '/assets/upload/jobs/' . $filename;
                } else {
                    $errors[] = "Gagal mengunggah poster.";
                }
            }
        }

        // Jika error, redirect kembali
        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            header("Location:/SukaInfo_app/createJobs");
            exit;
        }

        // Simpan ke database
        $stmt = $this->conn->prepare("INSERT INTO lowongans 
        (judul, perusahaan, lokasi, jenis_pekerjaan, gaji, tanggal_berakhir, poster, deskripsi) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssssssss",
            $judul,
            $perusahaan,
            $lokasi,
            $jenis_pekerjaan,
            $gaji,
            $tanggal_berakhir,
            $poster,
            $deskripsi
        );

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Lowongan berhasil disimpan.";
        } else {
            $_SESSION['flash_error'] = "Gagal menyimpan: " . $stmt->error;
        }

        $stmt->close();
        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
    public function delete()
    {
        session_start();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID lowongan tidak ditemukan.";
            header("Location: /SukaInfo_app/jobs");
            exit;
        }

        // Cek apakah data ada
        $check = $this->conn->prepare("SELECT id FROM lowongans WHERE id = ?");
        $check->bind_param("i", $id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            $_SESSION['flash_error'] = "Lowongan tidak ditemukan.";
            header("Location: /SukaInfo_app/jobs");
            exit;
        }

        $check->close();

        // Hapus data
        $stmt = $this->conn->prepare("DELETE FROM lowongans WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Lowongan berhasil dihapus.";
        } else {
            $_SESSION['flash_error'] = "Gagal menghapus lowongan: " . $stmt->error;
        }

        $stmt->close();
        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
    public function show()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            header("Location: /SukaInfo_app/jobs");
            exit;
        }

        $stmt = $this->conn->prepare("SELECT * FROM lowongans WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash_error'] = "Lowongan tidak ditemukan.";
            header("Location: /SukaInfo_app/jobs");
            exit;
        }

        $lowongan = $result->fetch_assoc();
        $stmt->close();

        require __DIR__ . '/../views/admin/pages/jobs/detail.php';
    }
}
