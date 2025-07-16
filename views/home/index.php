<?php
// === mulai session jika login === //
$title = "Sukabumi Muda"
?>
<!-- === struktur html === -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <?php include('views/layouts/header.php') ?>
    <!-- === component header === -->
    <header class="hero">
        <h1>Hai, Sobat Muda Sukabumi!</h1>
        <p>Website buat anak keren Sukabumi</p>
    </header>
    <!-- === end component header === -->

    <!-- === component body === -->
    <main class="container">
        <section id="hot-news">
            <h2>Hot News</h2>
            <div class="section-grid hot-news-grid">
                <?php if (!empty($artikels)): ?>
                    <?php foreach ($artikels as $artikel): ?>
                        <a href="/SukaInfo_app/detailArtikel?id=<?= $artikel['id'] ?>" class="card">
                            <div class="card-img-container">
                                <img src="<?= htmlspecialchars($artikel['thumbnail']) ?>" alt="<?= htmlspecialchars($artikel['judul']) ?>">
                            </div>
                            <div class="card-content">
                                <h3><?= htmlspecialchars($artikel['judul']) ?></h3>
                                <p><?= htmlspecialchars(substr(strip_tags($artikel['konten']), 0, 100)) ?>...</p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Tidak ada artikel terbaru.</p>
                <?php endif; ?>
            </div>

            <div class="more-button-container">
                <a href="hot-news-full.html" class="more-button">Tampilkan Lebih Banyak Berita</a>
            </div>
        </section>

        <section id="info-loker">
            <h2>Info Loker</h2>
            <div class="section-grid loker-acara-grid">
                <?php foreach ($lowongans as $job): ?>
                    <a href="/SukaInfo_app/lowongan/detail?id=<?= $job['id'] ?>" class="card">
                        <div class="card-img-container">
                            <img src="/SukaInfo_app/<?= htmlspecialchars($job['poster']) ?: 'assets/img/default-job.png' ?>" alt="<?= htmlspecialchars($job['judul']) ?>">
                        </div>
                        <div class="card-content">
                            <h3><?= htmlspecialchars($job['judul']) ?></h3>
                            <p><?= substr(strip_tags($job['deskripsi']), 0, 150) ?>...</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="more-button-container">
                <a href="info-loker-full.html" class="more-button">Tampilkan Lebih Banyak Loker</a>
            </div>
        </section>

        <section id="acara">
            <h2>Acara di Sukabumi</h2>
            <div class="section-grid loker-acara-grid">
                <?php foreach ($events as $event): ?>
                    <a href="/SukaInfo_app/event/detail?id=<?= $event['id'] ?>" class="card">
                        <div class="card-img-container">
                            <img src="/SukaInfo_app/<?= htmlspecialchars($event['poster']) ?: 'assets/img/default-event.png' ?>" alt="<?= htmlspecialchars($event['judul']) ?>">
                        </div>
                        <div class="card-content">
                            <h3><?= htmlspecialchars($event['judul']) ?></h3>
                            <p><?= substr(strip_tags($event['deskripsi']), 0, 150) ?>...</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="more-button-container">
                <a href="acara-full.html" class="more-button">Tampilkan Lebih Banyak Acara</a>
            </div>
        </section>

        <section id="rekomendasi">
            <h2>Rekomendasi Tempat di Sukabumi</h2>
            <div class="section-grid rekomendasi-grid">
                <a href="detail-tempat-1.html" class="card">
                    <div class="card-img-container">
                        <img src="asset/rekomendasi 1.png" alt="Cafe Hits Sukabumi">
                    </div>
                    <div class="card-content">
                        <h3>Motion Social Bar</h3>
                        <p>Tempat hangout kekinian di Sukabumi dengan suasana nyaman, cocok untuk nongkrong, ngopi, atau bersantai sambil menikmati live music. Pilihan menu makan dan minum beragam.</p>
                    </div>
                </a>
                <a href="detail-tempat-2.html" class="card">
                    <div class="card-img-container">
                        <img src="asset/rekomendasi 2.png" alt="Taman Kota Sukabumi">
                    </div>
                    <div class="card-content">
                        <h3>Waroeng Restoe Iboe</h3>
                        <p>Restoran keluarga dengan suasana tradisional dan menu masakan Indonesia rumahan yang autentik. Cocok untuk makan siang atau malam bersama keluarga.</p>
                    </div>
                </a>
                <a href="detail-tempat-3.html" class="card">
                    <div class="card-img-container">
                        <img src="asset/rekomendasi 3.png" alt="Wisata Alam Sukabumi">
                    </div>
                    <div class="card-content">
                        <h3>Mensa Coffee Sukabumi</h3>
                        <p>Kafe modern dengan desain minimalis, pilihan kopi spesial, dan makanan ringan yang cocok untuk bekerja, belajar, atau sekadar ngopi santai.</p>
                    </div>
                </a>
            </div>
            <div class="more-button-container">
                <a href="rekomendasi-full.html" class="more-button">Tampilkan Lebih Banyak Rekomendasi</a>
            </div>
        </section>
    </main>
    <!-- === end component body === -->

    <!-- === component hotline === -->
    <section id="hotline" class="hotline-section">
        <h2>Hotline Penting</h2>
        <ul class="hotline-list">
            <li>
                <div class="icon">
                    <img src="assets/asset/logo polres.png" alt="Ikon Polres">
                </div>
                <div class="info">
                    <strong>Polres Sukabumi</strong>
                    <a href="tel:+62811654110">0811-654-110</a>
                </div>
            </li>
            <li>
                <div class="icon">
                    <img src="assets/asset/logo dinsos.png" alt="Ikon Dinas Sosial">
                </div>
                <div class="info">
                    <strong>Dinas Sosial Kota Sukabumi</strong>
                    <a href="tel:+6281288449433">0812-8844-9433</a>
                </div>
            </li>
            <li>
                <div class="icon">
                    <img src="assets/asset/logo psc .png" alt="Ikon Public Safety Center">
                </div>
                <div class="info">
                    <strong>Public Safety Center</strong>
                    <a href="tel:+628001000119">0800-1000-119</a> / <a href="tel:119">119</a>
                </div>
            </li>
            <li>
                <div class="icon">
                    <img src="assets/asset/logo-linktree-1536.png" alt="Ikon Public Safety Center">
                </div>
                <div class="info">
                    <strong>LinkTree</strong>
                    <a href="https://linktr.ee/HotlinePentingNih">https://linktr.ee</a>
                </div>
            </li>
        </ul>
    </section>
    <!-- === end component hotline === -->

    <!-- === component footer === -->
    <?php include('views/layouts/footer.php') ?>
    <!-- === end component footer === -->
</body>
<script src="assets/js/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</html>