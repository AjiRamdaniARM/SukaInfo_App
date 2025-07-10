<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel - Sukabumi Muda</title>
    <?php include __DIR__ . '/../../components/header.php'; ?>
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
</head>

<body>
    <?php
    // Simulasi $artikel jika belum ada controller
    // $artikel = [...];
    $selectedTags = json_decode($artikel['tag'] ?? '[]', true);
    ?>

    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include __DIR__ . '/../../components/navbar.php'; ?>

        <main class="admin-main-content container py-4">
            <h1 class="fw-bold mb-4">Edit Data Artikel</h1>

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

            <form method="POST" action="/SukaInfo_app/artikel/update?id=<?= $artikel['id'] ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-80">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel *</label>
                            <input type="text" name="judul" id="judul" class="form-control" value="<?= htmlspecialchars($artikel['judul']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug (Opsional)</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="<?= htmlspecialchars($artikel['slug']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori *</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="teknologi" <?= $artikel['kategori'] === 'teknologi' ? 'selected' : '' ?>>Teknologi</option>
                                <option value="kesehatan" <?= $artikel['kategori'] === 'kesehatan' ? 'selected' : '' ?>>Kesehatan</option>
                                <option value="lifestyle" <?= $artikel['kategori'] === 'lifestyle' ? 'selected' : '' ?>>Lifestyle</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tag (Opsional):</label><br>
                            <input class="form-check-input" type="checkbox" name="tag[]" value="tips" <?= in_array('tips', $selectedTags) ? 'checked' : '' ?>> Tips
                            <input class="form-check-input" type="checkbox" name="tag[]" value="tutorial" <?= in_array('tutorial', $selectedTags) ? 'checked' : '' ?>> Tutorial
                            <input class="form-check-input" type="checkbox" name="tag[]" value="coding" <?= in_array('coding', $selectedTags) ? 'checked' : '' ?>> Coding
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Artikel</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="form-control">
                            <?php if (!empty($artikel['thumbnail'])): ?>
                                <small>Thumbnail saat ini: <img src="/SukaInfo_app/<?= $artikel['thumbnail'] ?>" width="100"></small>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis (Opsional)</label>
                            <input type="text" name="penulis" id="penulis" class="form-control" value="<?= htmlspecialchars($artikel['penulis']) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Artikel</label><br>
                            <input class="form-check-input" type="radio" name="status" value="draft" <?= $artikel['status'] === 'draft' ? 'checked' : '' ?>> Draft
                            <input class="form-check-input" type="radio" name="status" value="publish" <?= $artikel['status'] === 'publish' ? 'checked' : '' ?>> Publish
                            <input class="form-check-input" type="radio" name="status" value="scheduled" <?= $artikel['status'] === 'scheduled' ? 'checked' : '' ?>> Scheduled
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
                            <input type="date" name="tanggal_publish" id="tanggal_publish" class="form-control" value="<?= $artikel['tanggal_publish'] ?>">
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="mb-3">
                            <label for="editor" class="form-label">Konten Artikel *</label>
                            <div id="editor" style="height: 300px;" class="form-control bg-white"></div>
                            <input type="hidden" name="konten" id="konten">
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Artikel</button>
                </div>
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
        quill.root.innerHTML = <?= json_encode($artikel['konten']) ?>;

        document.querySelector('form').addEventListener('submit', function() {
            document.querySelector('#konten').value = quill.root.innerHTML;
        });
    </script>
</body>

</html>