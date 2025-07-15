<?php

class PenggunaController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
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
    public function update($data)
    {
        $id       = $data['id'];
        $username = $data['username'];
        $email    = $data['email'];
        $password = $data['password'];

        // Validasi dasar
        if (!$id || !$username || !$email) {
            $_SESSION['flash_error'] = "Semua field wajib diisi.";
            header("Location: /pengguna/edit?id=$id");
            exit;
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssi", $username, $email, $hashedPassword, $id);
        } else {
            $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssi", $username, $email, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Data pengguna berhasil diperbarui.";
            header("Location: /admin/index.php");
            exit;
        } else {
            $_SESSION['flash_error'] = "Gagal memperbarui data: " . $this->conn->error;
            header("Location: /pengguna/edit?id=$id");
            exit;
        }
    }
}
