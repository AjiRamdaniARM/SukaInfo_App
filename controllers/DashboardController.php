<?php

class DashboardController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db; // mysqli connection
    }

    public function index()
    {
        // Ambil total artikel
        $resultArtikel = $this->conn->query("SELECT COUNT(*) AS total FROM artikels");

        if (!$resultArtikel) {
            die("Query error (artikel): " . $this->conn->error);
        }

        $dataArtikel = $resultArtikel->fetch_assoc();
        $totalArtikel = $dataArtikel['total'];

        // Ambil data pengguna
        $resultUsers = $this->conn->query("SELECT * FROM pengguna");

        if (!$resultUsers) {
            die("Query error (users): " . $this->conn->error);
        }

        $users = [];

        while ($row = $resultUsers->fetch_assoc()) {
            $users[] = $row;
        }

        // Kirim data ke view
        require __DIR__ . '/../views/admin/index.php';
    }
}
