<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rekomendasi Tempat - Sukabumi Muda</title>
    <?php include __DIR__ . '/../../components/header.php'; ?>
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
</head>

<body>
    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include __DIR__ . '/../../components/navbar.php'; ?>

        <main class="admin-main-content container py-4">
            <h1 class="fw-bold mb-4">Edit Rekomendasi Tempat</h1>

            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['flash_success'];
                                                    unset($_SESSION['flash_success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['flash_error'];
                                                unset($_SESSION['flash_error']); ?></div>
            <?php endif; ?>

            <form method="POST" action="/SukaInfo_app/Rekomendasi/update?id=<?= $tempat['id'] ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_tempat" class="form-label">Nama Tempat *</label>
                    <input type="text" name="nama_tempat" id="nama_tempat" class="form-control" required
                        value="<?= htmlspecialchars($tempat['nama_tempat']) ?>">
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Wisata" <?= $tempat['kategori'] == 'Wisata' ? 'selected' : '' ?>>Wisata</option>
                        <option value="Kuliner" <?= $tempat['kategori'] == 'Kuliner' ? 'selected' : '' ?>>Kuliner</option>
                        <option value="Sejarah" <?= $tempat['kategori'] == 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
                        <option value="Lainnya" <?= $tempat['kategori'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi *</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" required
                        value="<?= htmlspecialchars($tempat['lokasi']) ?>">
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Rekomendasi *</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required
                        value="<?= htmlspecialchars($tempat['tanggal']) ?>">
                </div>

                <div class="mb-3">
                    <label for="poster" class="form-label">Gambar Tempat (Opsional)</label>
                    <input type="file" name="poster" id="poster" accept="image/*" class="form-control">
                    <?php if (!empty($tempat['poster'])): ?>
                        <div class="mt-2">
                            <small>Poster saat ini:</small><br>
                            <img src="/SukaInfo_app/<?= $tempat['poster'] ?>" width="150" alt="Poster Tempat">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="editor" class="form-label">Deskripsi Tempat *</label>
                    <div id="editor" class="form-control bg-white" style="height: 300px;"></div>
                    <input type="hidden" name="deskripsi" id="konten">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="publish" <?= $tempat['status'] == 'publish' ? 'selected' : '' ?>>Publish</option>
                        <option value="draft" <?= $tempat['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </main>

        <footer class="text-center py-4 mt-5 bg-light">
            <p>&copy; 2025 Sukabumi Muda. All rights reserved.</p>
        </footer>
    </section>

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Set isi awal dari editor
        quill.root.innerHTML = `<?= str_replace("`", "\`", $tempat['deskripsi']) ?>`;

        document.querySelector('form').addEventListener('submit', function() {
            document.querySelector('#konten').value = quill.root.innerHTML;
        });
    </script>
</body>

</html>