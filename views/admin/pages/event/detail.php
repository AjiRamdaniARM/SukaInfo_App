<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['judul']) ?> - Sukabumi Muda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/SukaInfo_app/assets/css/style.css" />
</head>

<body>
    <?php include('./views/layouts/header.php') ?>

    <header class="hero small-hero">
        <h1><?= htmlspecialchars($event['judul']) ?></h1>
        <p><?= date('d M Y', strtotime($event['tanggal'])) ?> - <?= htmlspecialchars($event['lokasi']) ?></p>
    </header>

    <main class="container">
        <div class="detail-content-wrapper">
            <div class="detail-berita">
                <h2 class="detail-title"><?= htmlspecialchars($event['judul']) ?></h2>

                <div class="detail-meta">
                    <span class="detail-date"><?= date('d M Y', strtotime($event['tanggal'])) ?></span>
                    <span class="detail-location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($event['lokasi']) ?></span>
                </div>

                <?php if (!empty($event['poster'])): ?>
                    <div class="detail-image-container">
                        <img src="/SukaInfo_app/<?= htmlspecialchars($event['poster']) ?>" alt="Poster Event" class="detail-image">
                    </div>
                <?php endif; ?>

                <div class="detail-body">
                    <?= $event['deskripsi'] ?>
                </div>

                <div class="back-button-container mt-4">
                    <a href="/SukaInfo_app/#event" class="more-button">← Kembali ke Daftar Event</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Sukabumi Muda. Semua Hak Cipta Dilindungi.</p>
    </footer>
</body>

</html>