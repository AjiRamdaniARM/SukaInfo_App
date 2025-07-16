<?php

class HomeController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db; // mysqli connection
    }

    public function index()
    {
        // Ambil total artikel dengan status 'publish'
        $resultCount = $this->conn->query("SELECT COUNT(*) AS total FROM artikels WHERE status = 'publish'");
        if (!$resultCount) {
            die("Query error: " . $this->conn->error);
        }
        $dataCount = $resultCount->fetch_assoc();
        $totalArtikel = $dataCount['total'];

        // Ambil daftar artikel dengan status 'publish'
        $resultArticles = $this->conn->query("SELECT * FROM artikels WHERE status = 'publish' ORDER BY created_at DESC");
        if (!$resultArticles) {
            die("Query error: " . $this->conn->error);
        }

        // Simpan semua artikel ke array
        $artikels = [];
        while ($row = $resultArticles->fetch_assoc()) {
            $artikels[] = $row;
        }

        $resultLowongans = $this->conn->query("SELECT * FROM lowongans ORDER BY tanggal_berakhir DESC LIMIT 4");
        $lowongans = [];
        if ($resultLowongans) {
            while ($row = $resultLowongans->fetch_assoc()) {
                $lowongans[] = $row;
            }
        }

        $resultEvents = $this->conn->query("SELECT * FROM events ORDER BY tanggal DESC LIMIT 4");
        $events = [];
        if ($resultEvents) {
            while ($row = $resultEvents->fetch_assoc()) {
                $events[] = $row;
            }
        }

        // Kirim ke view
        require __DIR__ . '/../views/home/index.php';
    }
}
