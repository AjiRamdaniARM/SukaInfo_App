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
                <a href="detail-loker-1.html" class="card">
                    <div class="card-img-container">
                        <img src="asset/info loker 1.png" alt="Lowongan Kerja Admin">
                    </div>
                    <div class="card-content">
                        <h3>INFOSMI Buka Kesempatan Magang Batch 14!</h3>
                        <p>Bagi kamu yang ingin mendapatkan pengalaman di dunia kerja, segera cek info lengkapnya di Instagram @infosmigroup! Ini adalah kesempatan emas untuk belajar dan berkembang bersama INFOSMI.</p>
                    </div>
                </a>
                <a href="detail-loker-2.html" class="card">
                    <div class="card-img-container">
                        <img src="asset/info loker 2.png" alt="Lowongan Kerja Desainer Grafis">
                    </div>
                    <div class="card-content">
                        <h3>Like Earth Coffee Cari Waiter Secepatnya!</h3>
                        <p>Like Earth Coffee buka lowongan Waiter di Sukabumi. Minimal SMK/D3, pria/wanita, rapi & bertanggung jawab. Kirim lamaranmu langsung ke alamat dan whatsapp tertera.</p>
                    </div>
                </a>
            </div>
            <div class="more-button-container">
                <a href="info-loker-full.html" class="more-button">Tampilkan Lebih Banyak Loker</a>
            </div>
        </section>

        <section id="acara">
            <h2>Acara di Sukabumi</h2>
            <div class="section-grid loker-acara-grid">
                <a href="detail-acara-1.html" class="card">
                    <div class="card-img-container">
                        <img src="asset/acara 1.png" alt="Konser Musik Sukabumi">
                    </div>
                    <div class="card-content">
                        <h3>Sukabumi Nyerenteng #Vol1: Ajang Pertarungan Sengit di Gor Merdeka Sukabumi!</h3>
                        <p>Sukabumi Nyerenteng #Vol1 hadir 11-12 Juli 2025 di Gor Merdeka! Siap-siap untuk MMA Striking, Three on Three, Digulung, & Freestyle Boxing. Daftar Rp250 ribu ke Admin.</p>
                    </div>
                </a>
                <a href="detail-acara-2.html" class="card">
                    <div class="card-img-container">
                        <img src="asset/acara 2.png" alt="Workshop Kreatif Sukabumi">
                    </div>
                    <div class="card-content">
                        <h3>INFOSMI LIVE Hadirkan "Bake Me Happiness Layer 3" Besok!</h3>
                        <p>INFOSMI LIVE gelar "Bake Me Happiness Layer 3" besok, 22 Juni 2025, di Secret Garden Sukabumi. Ikuti kelas baking kue seharga 120K, dapatkan kit lengkap, sertifikat, & doorprize.</p>
                    </div>
                </a>
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