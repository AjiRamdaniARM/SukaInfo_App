<?php

class ArtikelController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db; // mysqli connection
    }

    public function store()
    {
        session_start();

        // Ambil data dari POST
        $judul           = trim($_POST['judul'] ?? '');
        $slug            = trim($_POST['slug'] ?? '');
        $kategori        = $_POST['kategori'] ?? '';
        $penulis         = $_POST['penulis'] ?? '';
        $status          = $_POST['status'] ?? '';
        $tanggal_publish = $_POST['tanggal_publish'] ?? null;
        $konten          = trim($_POST['konten'] ?? '');
        $tags            = $_POST['tag'] ?? [];

        $errors = [];

        // === Validasi ===
        if (empty($judul)) $errors[] = "Judul wajib diisi.";
        if (empty($kategori)) $errors[] = "Kategori harus dipilih.";
        if (empty($konten)) $errors[] = "Konten artikel tidak boleh kosong.";
        if (!in_array($status, ['draft', 'publish', 'scheduled'])) {
            $errors[] = "Status tidak valid.";
        }

        if (!empty($tanggal_publish)) {
            $validDate = DateTime::createFromFormat('Y-m-d', $tanggal_publish);
            if (!$validDate || $validDate->format('Y-m-d') !== $tanggal_publish) {
                $errors[] = "Tanggal publish tidak valid.";
            }
        }

        // Slug otomatis jika kosong
        if (empty($slug)) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $judul));
        }

        // === Validasi dan Upload Thumbnail ===
        $thumbnail = null;
        if (!empty($_FILES['thumbnail']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $mimeType = $_FILES['thumbnail']['type'];
            $fileSize = $_FILES['thumbnail']['size'];

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "Format thumbnail harus berupa gambar (jpg, jpeg, png, webp).";
            } elseif ($fileSize > 2 * 1024 * 1024) {
                $errors[] = "Ukuran thumbnail maksimal 2MB.";
            } else {
                $uploadDir = __DIR__ . '/../assets/upload/artikel/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename = uniqid() . '_' . basename($_FILES['thumbnail']['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                    $thumbnail = 'assets/upload/artikel/' . $filename; // simpan path relatif
                } else {
                    $errors[] = "Gagal mengupload thumbnail.";
                }
            }
        }

        // Jika ada error validasi
        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            header("Location: /SukaInfo_app/createArtikel");
            exit;
        }

        // Simpan ke database
        $tag_json = json_encode($tags);

        $stmt = $this->conn->prepare("INSERT INTO artikels 
        (judul, slug, kategori, tag, thumbnail, penulis, status, tanggal_publish, konten)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssssssss",
            $judul,
            $slug,
            $kategori,
            $tag_json,
            $thumbnail,
            $penulis,
            $status,
            $tanggal_publish,
            $konten
        );

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Artikel berhasil disimpan.";
        } else {
            $_SESSION['flash_error'] = "Gagal menyimpan artikel: " . $stmt->error;
        }

        $stmt->close();
        header("Location: /SukaInfo_app/createArtikel");
        exit;
    }

    public function update()
    {


        // Ambil ID dari URL
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            $_SESSION['flash_error'] = "ID artikel tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        // Ambil data dari POST
        $judul           = trim($_POST['judul'] ?? '');
        $slug            = trim($_POST['slug'] ?? '');
        $kategori        = $_POST['kategori'] ?? '';
        $penulis         = $_POST['penulis'] ?? '';
        $status          = $_POST['status'] ?? '';
        $tanggal_publish = $_POST['tanggal_publish'] ?? null;
        $konten          = trim($_POST['konten'] ?? '');
        $tags            = $_POST['tag'] ?? [];

        $errors = [];

        // === Validasi ===
        if (empty($judul)) $errors[] = "Judul wajib diisi.";
        if (empty($kategori)) $errors[] = "Kategori harus dipilih.";
        if (empty($konten)) $errors[] = "Konten artikel tidak boleh kosong.";
        if (!in_array($status, ['draft', 'publish', 'scheduled'])) {
            $errors[] = "Status tidak valid.";
        }

        if (!empty($tanggal_publish)) {
            $validDate = DateTime::createFromFormat('Y-m-d', $tanggal_publish);
            if (!$validDate || $validDate->format('Y-m-d') !== $tanggal_publish) {
                $errors[] = "Tanggal publish tidak valid.";
            }
        }

        // Slug otomatis jika kosong
        if (empty($slug)) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $judul));
        }

        // === Validasi dan Upload Thumbnail ===
        $thumbnail = null;
        if (!empty($_FILES['thumbnail']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $mimeType = $_FILES['thumbnail']['type'];
            $fileSize = $_FILES['thumbnail']['size'];

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "Format thumbnail harus berupa gambar (jpg, jpeg, png, webp).";
            } elseif ($fileSize > 2 * 1024 * 1024) {
                $errors[] = "Ukuran thumbnail maksimal 2MB.";
            } else {
                $uploadDir = __DIR__ . '/../assets/upload/artikel/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename = uniqid() . '_' . basename($_FILES['thumbnail']['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                    $thumbnail = 'assets/upload/artikel/' . $filename; // path relatif
                } else {
                    $errors[] = "Gagal mengupload thumbnail.";
                }
            }
        }

        // Jika ada error validasi
        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            header("Location: /SukaInfo_app/artikel/edit?id=$id");
            exit;
        }

        // Simpan ke database
        $tag_json = json_encode($tags);

        // Tentukan query berdasarkan ada tidaknya thumbnail baru
        if ($thumbnail) {
            $stmt = $this->conn->prepare("
            UPDATE artikels 
            SET judul = ?, slug = ?, kategori = ?, tag = ?, thumbnail = ?, penulis = ?, status = ?, tanggal_publish = ?, konten = ? 
            WHERE id = ?
        ");
            $stmt->bind_param(
                "sssssssss",
                $judul,
                $slug,
                $kategori,
                $tag_json,
                $thumbnail,
                $penulis,
                $status,
                $tanggal_publish,
                $konten
            );
        } else {
            $stmt = $this->conn->prepare("
            UPDATE artikels 
            SET judul = ?, slug = ?, kategori = ?, tag = ?, penulis = ?, status = ?, tanggal_publish = ?, konten = ? 
            WHERE id = ?
        ");
            $stmt->bind_param(
                "ssssssssi",
                $judul,
                $slug,
                $kategori,
                $tag_json,
                $penulis,
                $status,
                $tanggal_publish,
                $konten,
                $id
            );
        }

        // Eksekusi query
        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Artikel berhasil diperbarui.";
        } else {
            $_SESSION['flash_error'] = "Gagal memperbarui artikel: " . $stmt->error;
        }

        $stmt->close();
        header("Location: /SukaInfo_app/artikel/edit?id=$id");
        exit;
    }


    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash_error'] = "ID artikel tidak valid.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        $stmt = $this->conn->prepare("SELECT * FROM artikels WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $artikel = $result->fetch_assoc();

        if (!$artikel) {
            $_SESSION['flash_error'] = "Artikel tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        // Kirim ke view
        require __DIR__ . '/../views/admin/pages/artikel/edit.php';
    }


    public function detail()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash_error'] = "ID artikel tidak valid.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        $stmt = $this->conn->prepare("SELECT * FROM artikels WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $artikel = $result->fetch_assoc();

        if (!$artikel) {
            $_SESSION['flash_error'] = "Artikel tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }
        // Kirim ke view
        require __DIR__ . '/../views/admin/pages/artikel/detail.php';
    }


    public function delete()
    {
        session_start();

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['flash_error'] = "ID artikel tidak valid.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        $id = (int) $_GET['id'];

        // Cek apakah artikel ada
        $stmtCheck = $this->conn->prepare("SELECT thumbnail FROM artikels WHERE id = ?");
        $stmtCheck->bind_param("i", $id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash_error'] = "Artikel tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        $artikel = $result->fetch_assoc();
        $stmtCheck->close();

        // Hapus file thumbnail jika ada
        if (!empty($artikel['thumbnail'])) {
            $thumbnailPath = __DIR__ . '/../' . $artikel['thumbnail'];
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        // Hapus dari database
        $stmtDelete = $this->conn->prepare("DELETE FROM artikels WHERE id = ?");
        $stmtDelete->bind_param("i", $id);

        if ($stmtDelete->execute()) {
            $_SESSION['flash_success'] = "Artikel berhasil dihapus.";
        } else {
            $_SESSION['flash_error'] = "Gagal menghapus artikel.";
        }

        $stmtDelete->close();

        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
}
