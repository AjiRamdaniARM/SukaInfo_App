<?php
// === mulai session jika login === //
$title = "Sukabumi Muda - Forgot Password"
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-header-logo">
            <h1>Sukabumi Muda</h1>
            <p>Atur Ulang Kata Sandi Anda</p> </div>

        <div class="login-box">
            <h2>Lupa Password</h2> <form action="#" method="POST">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Anda</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email terdaftar Anda" required>
                </div>
                <button type="submit" class="login-button">Kirim Link Reset</button> </form>
            <div class="forgot-password">
                <a href="admin-login.html">Kembali ke Halaman Login</a> </div>
        </div>
    </div>
</body>
</html>