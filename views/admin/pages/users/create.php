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
    $selectedTags = json_decode($artikel['tag'] ?? '[]', true);
    ?>

    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include __DIR__ . '/../../components/navbar.php'; ?>

        <main class="admin-main-content container py-4">
            <h1 class="fw-bold mb-4">Tambah Data Pengguna</h1>

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

            <form method="POST" action="/SukaInfo_app/pengguna/store" enctype="multipart/form-data">
                <div class="row">
                    <div class="container">
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username *</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Tambah Pengguna</button>
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