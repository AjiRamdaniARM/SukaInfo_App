<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rekomendasi Tempat - Sukabumi Muda</title>
    <?php include __DIR__ . '/../../components/header.php'; ?>
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
</head>

<body>
    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include __DIR__ . '/../../components/navbar.php'; ?>

        <main class="admin-main-content container py-4">
            <h1 class="fw-bold mb-4">Tambah Rekomendasi Tempat</h1>

            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['flash_success'];
                                                    unset($_SESSION['flash_success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['flash_error'];
                                                unset($_SESSION['flash_error']); ?></div>
            <?php endif; ?>

            <form method="POST" action="/SukaInfo_app/Rekomendasi/store" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_tempat" class="form-label">Nama Tempat *</label>
                    <input type="text" name="nama_tempat" id="nama_tempat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Wisata">Wisata</option>
                        <option value="Kuliner">Kuliner</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi *</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Rekomendasi *</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="poster" class="form-label">Gambar Tempat</label>
                    <input type="file" name="poster" id="poster" accept="image/*" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="editor" class="form-label">Deskripsi Tempat *</label>
                    <div id="editor" class="form-control bg-white" style="height: 300px;"></div>
                    <input type="hidden" name="deskripsi" id="konten">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="publish">Publish</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Simpan Rekomendasi</button>
            </form>
        </main>

        <footer class="text-center py-4 mt-5 bg-light">
            <p>&copy; 2025 Sukabumi Muda. All rights reserved.</p>
        </footer>
    </section>

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