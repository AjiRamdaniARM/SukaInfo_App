<?php
// === mulai session jika login === //
$title = "Sukabumi Muda - Login Admin"
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
        </div>

        <div class="login-box">
            <h2>Login Admin</h2>
            <div class="alert alert-danger" id="error" role="alert">
                A simple danger alert—check it out!
            </div>
            <form id="login-form" method="POST"> <div class="form-group">
                    <label for="email"><i class="fas fa-user"></i> Username atau Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan  email Anda" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                </div>
                <button type="submit" id="login-btn" class="login-button">
                    <span id="login-btn-text">Login</span>
                    <span id="login-btn-loading" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>

            </form>
            <div class="forgot-password">
                <a href="forgot-password.html">Lupa Password?</a>
            </div>
        </div>
    </div>
   <script>
    $(document).ready(function () {
        $('#login-form').on('submit', function (e) {
            e.preventDefault();
             // Reset error dan tampilkan loading
            $('#error').addClass('d-none').text('');
            $('#login-btn').attr('disabled', true);
            $('#login-btn-text').text('Loading...');
            $('#login-btn-loading').removeClass('d-none');

            // Reset error box dulu sebelum request
            $('#error').addClass('d-none').text('');

            $.ajax({
                url: '/SukaInfo_app/login',
                method: 'POST',
                data: $(this).serialize(),
              
                success: function (response) {
                    if (response.success) {
                        window.location.href = "/SukaInfo_app/dashboard";
                    } else {
                        $('#error')
                            .removeClass('d-none')
                            .removeClass('hidden') // Tailwind
                            .text(response.message || 'Login gagal.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText); // untuk debugging
                    $('#error')
                        .removeClass('d-none')
                        .removeClass('hidden')
                        .text("Terjadi kesalahan server.");
                },
                complete: function () {
                    $('#login-btn').attr('disabled', false);
                    $('#login-btn-text').text('Login');
                    $('#login-btn-loading').addClass('d-none');
                }
            });
        });
    });
</script>

</body>
</html>