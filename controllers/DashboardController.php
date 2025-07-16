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
        // Ambil total data dari berbagai tabel
        $resultArtikel     = $this->conn->query("SELECT COUNT(*) AS total FROM artikels");
        $resultPengguna    = $this->conn->query("SELECT COUNT(*) AS totalPengguna FROM pengguna");
        $resultJobs        = $this->conn->query("SELECT COUNT(*) AS totallowongans FROM lowongans");
        $resultEvents      = $this->conn->query("SELECT COUNT(*) AS totalEvents FROM events");
        $resultRekomendasi = $this->conn->query("SELECT COUNT(*) AS totalRekomendasi FROM tempats");

        // Validasi hasil query
        if (!$resultArtikel || !$resultPengguna || !$resultJobs || !$resultEvents || !$resultRekomendasi) {
            die("Query error: " . $this->conn->error);
        }

        // Ambil hasil query
        $dataArtikel      = $resultArtikel->fetch_assoc();
        $dataPengguna     = $resultPengguna->fetch_assoc();
        $dataLowongans    = $resultJobs->fetch_assoc();
        $dataEvents       = $resultEvents->fetch_assoc();
        $dataRekomendasi  = $resultRekomendasi->fetch_assoc();

        // Total data
        $totalArtikel       = $dataArtikel['total'];
        $totalPengguna      = $dataPengguna['totalPengguna'];
        $totalLowongans     = $dataLowongans['totallowongans'];
        $totalEvents        = $dataEvents['totalEvents'];
        $totalRekomendasi   = $dataRekomendasi['totalRekomendasi'];

        // Ambil data pengguna
        $resultUsers = $this->conn->query("SELECT * FROM pengguna");
        $users       = $resultUsers ? $resultUsers->fetch_all(MYSQLI_ASSOC) : [];

        // Ambil data lowongan
        $resultLowongans = $this->conn->query("SELECT * FROM lowongans ORDER BY tanggal_berakhir DESC");
        $lowongans       = $resultLowongans ? $resultLowongans->fetch_all(MYSQLI_ASSOC) : [];

        // Ambil data event
        $resultEventsData = $this->conn->query("SELECT * FROM events ORDER BY tanggal DESC");
        $events           = $resultEventsData ? $resultEventsData->fetch_all(MYSQLI_ASSOC) : [];

        // Ambil data rekomendasi tempat
        $resultRekomendasiData = $this->conn->query("SELECT * FROM tempats ORDER BY tanggal DESC");
        $rekomendasis           = $resultRekomendasiData ? $resultRekomendasiData->fetch_all(MYSQLI_ASSOC) : [];

        // Kirim ke view
        require __DIR__ . '/../views/admin/index.php';
    }
}
