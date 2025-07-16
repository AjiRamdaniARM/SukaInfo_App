<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukabumi Muda - Admin Panel (Front-end Demo)</title>
    <?php include __DIR__ . '/../../components/header.php'; ?>
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
</head>

<body>
    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include __DIR__ . '/../../components/navbar.php'; ?>

        <main class="admin-main-content container py-4">
            <!-- Title -->
            <h1 class="fw-bold mb-4">Tambah Data Artikel Baru</h1>

            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['flash_success'];
                    unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['flash_error'];
                    unset($_SESSION['flash_error']); ?>
                </div>
            <?php endif; ?>


            <!-- Form Tambah Artikel -->
            <form method="POST" action="/SukaInfo_app/Jobs/store" enctype="multipart/form-data">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-80">
                        <!-- Judul Lowongan -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Lowongan *</label>
                            <input type="text" name="judul" id="judul" class="form-control" placeholder="Contoh: Lowongan Web Developer di Bandung" required>
                        </div>

                        <!-- Perusahaan -->
                        <div class="mb-3">
                            <label for="perusahaan" class="form-label">Nama Perusahaan *</label>
                            <input type="text" name="perusahaan" id="perusahaan" class="form-control" placeholder="Contoh: PT Digital Karya" required>
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi *</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: Jakarta, Bandung" required>
                        </div>

                        <!-- Jenis Pekerjaan -->
                        <div class="mb-3">
                            <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan *</label>
                            <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-select" required>
                                <option value="">-- Pilih Jenis Pekerjaan --</option>
                                <option value="fulltime">Full-Time</option>
                                <option value="parttime">Part-Time</option>
                                <option value="magang">Magang</option>
                                <option value="freelance">Freelance</option>
                            </select>
                        </div>

                        <!-- Gaji -->
                        <div class="mb-3">
                            <label for="gaji" class="form-label">Gaji (Opsional)</label>
                            <input type="text" name="gaji" id="gaji" class="form-control" placeholder="Contoh: 4-6 juta / negotiable">
                        </div>

                        <!-- Tanggal Berakhir -->
                        <div class="mb-3">
                            <label for="tanggal_berakhir" class="form-label">Tanggal Penutupan *</label>
                            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control" required>
                        </div>

                        <!-- Thumbnail / Poster -->
                        <div class="mb-3">
                            <label for="poster" class="form-label">Poster / Thumbnail (Opsional)</label>
                            <input type="file" name="poster" id="poster" accept="image/*" class="form-control">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-12 mt-4">
                        <div class="mb-3">
                            <label for="editor" class="form-label">Deskripsi Pekerjaan *</label>
                            <div id="editor" style="height: 300px;" class="form-control bg-white"></div>
                            <input type="hidden" name="deskripsi" id="konten">
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Kirim Lowongan</button>
                </div>
            </form>

        </main>

        <footer class="text-center py-4 mt-5 bg-light">
            <p>&copy; 2025 Sukabumi Muda. All rights reserved.</p>
        </footer>
    </section>

    <!-- Script JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        document.querySelector('form').addEventListener('submit', function() {
            document.querySelector('#konten').value = quill.root.innerHTML;
        });
    </script>
</body>

</html>