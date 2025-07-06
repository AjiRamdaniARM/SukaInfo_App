<!DOCTYPE html>
<html lang="id">

<head>
    <title>Sukabumi Muda - Admin Panel (Front-end Demo)</title>
    <?php include __DIR__ . '/../../components/header.php'; ?>
</head>

<body>
    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include __DIR__ . '/../../components/navbar.php' ?>
        <main class="admin-main-content">
            <!-- === titile ===  -->
            <h1 class="fw-bold">Tambah data artikel baru</h1>
            <!-- === form === -->
            <div class="container contact-form">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="txtName" class="form-control" placeholder="Judul Artikel *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="txtEmail" class="form-control" placeholder="Your Email *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="txtPhone" class="form-control" placeholder="Your Phone Number *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="submit" name="btnSubmit" class="btn btn-dark" value="Send Message" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Quill Editor Container -->
                            <div class="form-group mb-4">
                                <!-- Editor visual (Quill akan masuk di sini) -->
                                <div id="editor" style="height: 300px;" class="border p-3 rounded-md bg-white"></div>

                                <!-- Hidden input yang dikirim ke server -->
                                <input type="hidden" name="konten" id="konten">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </main>
        <footer class="footer">
            <p>&copy; 2025 Sukabumi Muda. All rights reserved.</p>
        </footer>
    </section>
    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/dashboard.js"></script>
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