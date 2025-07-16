<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($lowongan['judul']) ?> - Sukabumi Muda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/SukaInfo_app/assets/css/style.css" />
</head>

<body>
    <?php include('./views/layouts/header.php') ?>

    <header class="hero small-hero">
        <h1><?= htmlspecialchars($lowongan['perusahaan']) ?></h1>
        <p><?= htmlspecialchars($lowongan['judul']) ?></p>
    </header>

    <main class="container">
        <div class="detail-content-wrapper">
            <div class="detail-berita">
                <h2 class="detail-title"><?= htmlspecialchars($lowongan['judul']) ?></h2>

                <div class="detail-meta">
                    <?php
                    $bulanIndo = [
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember'
                    ];

                    $tanggalObj = date_create($lowongan['tanggal_berakhir']);
                    $tanggal = date_format($tanggalObj, 'd');
                    $bulan = date_format($tanggalObj, 'm');
                    $tahun = date_format($tanggalObj, 'Y');
                    $tanggalIndo = ltrim($tanggal, '0') . ' ' . $bulanIndo[$bulan] . ' ' . $tahun;
                    ?>
                    <span class="detail-date">Batas Lamaran: <?= $tanggalIndo ?></span>
                    <span class="detail-category"><?= ucfirst($lowongan['jenis_pekerjaan']) ?></span>
                    <span class="detail-author">Lokasi: <?= htmlspecialchars($lowongan['lokasi']) ?></span>
                    <?php if (!empty($lowongan['gaji'])): ?>
                        <span class="detail-author">Gaji: <?= htmlspecialchars($lowongan['gaji']) ?></span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($lowongan['poster'])): ?>
                    <div class="detail-image-container">
                        <img src="/SukaInfo_app/<?= htmlspecialchars($lowongan['poster']) ?>" alt="<?= htmlspecialchars($lowongan['judul']) ?>" class="detail-image">
                    </div>
                <?php endif; ?>

                <div class="detail-body">
                    <?= $lowongan['deskripsi'] ?>
                </div>

                <div class="back-button-container">
                    <a href="/SukaInfo_app/jobs" class="more-button">Kembali ke Lowongan</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Sukabumi Muda. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <script src="/SukaInfo_app/js/script.js"></script>
</body>

</html>