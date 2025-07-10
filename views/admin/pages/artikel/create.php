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
            <form method="POST" action="/SukaInfo_app/artikel/store" enctype="multipart/form-data">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-80">
                        <!-- Judul -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel *</label>
                            <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan Judul Artikel" required>
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug (Opsional)</label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="contoh: judul-artikel-baru">
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori *</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="teknologi">Teknologi</option>
                                <option value="kesehatan">Kesehatan</option>
                                <option value="lifestyle">Lifestyle</option>
                            </select>
                        </div>

                        <!-- Tag -->
                        <div class="mb-3">
                            <label class="form-label">Tag (Opsional):</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="tag[]" id="tagTips" value="tips">
                                <label class="form-check-label" for="tagTips">Tips</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="tag[]" id="tagTutorial" value="tutorial">
                                <label class="form-check-label" for="tagTutorial">Tutorial</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="tag[]" id="tagCoding" value="coding">
                                <label class="form-check-label" for="tagCoding">Coding</label>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Artikel</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="form-control">
                        </div>

                        <!-- Penulis -->
                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis (Opsional)</label>
                            <input type="text" name="penulis" id="penulis" class="form-control" placeholder="Nama Penulis">
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status Artikel</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft" checked>
                                <label class="form-check-label" for="statusDraft">Draft</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusPublish" value="publish">
                                <label class="form-check-label" for="statusPublish">Publish</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusScheduled" value="scheduled">
                                <label class="form-check-label" for="statusScheduled">Scheduled</label>
                            </div>
                        </div>

                        <!-- Tanggal Publish -->
                        <div class="mb-3">
                            <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
                            <input type="date" name="tanggal_publish" id="tanggal_publish" class="form-control">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-12 mt-4">
                        <div class="mb-3">
                            <label for="editor" class="form-label">Konten Artikel *</label>
                            <div id="editor" style="height: 300px;" class="form-control bg-white"></div>
                            <input type="hidden" name="konten" id="konten">
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Publikasikan Artikel</button>
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