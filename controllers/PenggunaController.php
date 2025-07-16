<?php

class PenggunaController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function store()
    {


        // Ambil data dari POST
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $errors = [];

        // Validasi
        if (empty($username)) {
            $errors[] = "Username wajib diisi.";
        }

        if (empty($email)) {
            $errors[] = "Email wajib diisi.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid.";
        }

        if (empty($password)) {
            $errors[] = "Password wajib diisi.";
        }

        // Jika validasi gagal
        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            header("Location: /SukaInfo_app/pengguna/create");
            exit;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Simpan ke database
        $stmt = $this->conn->prepare("INSERT INTO pengguna (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Pengguna berhasil ditambahkan.";
        } else {
            $_SESSION['flash_error'] = "Gagal menambahkan pengguna: " . $stmt->error;
        }

        $stmt->close();
        header("Location: /SukaInfo_app/dashboard");
        exit;
    }


    // Tampilkan form edit berdasarkan ID
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        $stmt = $this->conn->prepare("SELECT * FROM pengguna WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            die("Pengguna tidak ditemukan");
        }

        $pengguna = $result->fetch_assoc();

        // Tampilkan view edit
        require __DIR__ . '/../views/admin/pages/users/edit.php';
    }

    // Proses update data
    public function update()
    {
        $id       = $_POST['id'];
        $username = $_POST['username'];
        $email    = $_POST['email'];
        $password = $_POST['password'];

        // Validasi dasar
        if (!$id || !$username || !$email) {
            $_SESSION['flash_error'] = "Semua field wajib diisi.";
            header("Location: /pengguna/pengguna?id=$id");
            exit;
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE pengguna SET username = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssi", $username, $email, $hashedPassword, $id);
        } else {
            $query = "UPDATE pengguna SET username = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssi", $username, $email, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Data pengguna berhasil diperbarui.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        } else {
            $_SESSION['flash_error'] = "Gagal memperbarui data: " . $this->conn->error;
            header("Location: /pengguna/edit?id=$id");
            exit;
        }
    }
    public function delete()
    {

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            $_SESSION['flash_error'] = "ID pengguna tidak ditemukan.";
            header("Location: /SukaInfo_app/dashboard");
            exit;
        }

        $stmt = $this->conn->prepare("DELETE FROM pengguna WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Pengguna berhasil dihapus.";
        } else {
            $_SESSION['flash_error'] = "Gagal menghapus pengguna: " . $stmt->error;
        }

        $stmt->close();
        header("Location: /SukaInfo_app/dashboard");
        exit;
    }
}
