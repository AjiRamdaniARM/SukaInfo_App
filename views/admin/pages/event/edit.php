<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - Sukabumi Muda</title>
    <?php include __DIR__ . '/../../components/header.php'; ?>
</head>

<body>
    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include __DIR__ . '/../../components/navbar.php'; ?>

        <main class="admin-main-content container py-4">
            <h1 class="fw-bold mb-4">Edit Data Event</h1>

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

            <form method="POST" action="/SukaInfo_app/Event/update?id=<?= $event['id'] ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Nama Event *</label>
                    <input type="text" name="judul" id="judul" class="form-control" required
                        value="<?= htmlspecialchars($event['judul']) ?>">
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal *</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required
                        value="<?= htmlspecialchars($event['tanggal']) ?>">
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi *</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" required
                        value="<?= htmlspecialchars($event['lokasi']) ?>">
                </div>

                <div class="mb-3">
                    <label for="poster" class="form-label">Poster (Opsional)</label>
                    <input type="file" name="poster" id="poster" class="form-control" accept="image/*">
                    <?php if (!empty($event['poster'])): ?>
                        <div class="mt-2">
                            <small>Poster saat ini:</small><br>
                            <img src="/SukaInfo_app/<?= $event['poster'] ?>" width="120" alt="Poster Event">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="mb-3">
                        <label for="editor" class="form-label">Deskripsi Event *</label>
                        <div id="editor" style="height: 300px;" class="form-control bg-white"></div>
                        <input type="hidden" name="deskripsi" id="konten">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </main>

        <footer class="text-center py-4 mt-5 bg-light">
            <p>&copy; 2025 Sukabumi Muda. All rights reserved.</p>
        </footer>
    </section>
    <!-- Script -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Tampilkan isi lama ke editor
        quill.root.innerHTML = <?= json_encode($event['deskripsi']) ?>;

        // Ambil isi saat form dikirim
        document.querySelector('form').addEventListener('submit', function() {
            document.querySelector('#konten').value = quill.root.innerHTML;
        });
    </script>

</body>

</html>