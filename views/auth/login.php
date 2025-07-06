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
            <!-- component alert login -->
            <div class="alert alert-danger invisible" id="error" role="alert">
            </div>
            <form id="login-form" method="POST"> <div class="form-group">
                    <label for="email"><i class="fas fa-user"></i> Username atau Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan  email Anda" required>
                </div>
                <div class="form-group position-relative">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" class="form-control pe-5" name="password" placeholder="Masukkan password Anda" required>
                        <span class="position-absolute end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;top:50px">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                </div>
                <button type="submit" id="loginButton" class="btn btn-primary btn-login w-100 py-2">
                    <span class="btn-text">Login</span>
                    <span class="spinner-border spinner-border-sm spinner d-none" role="status" aria-hidden="true"></span>
                </button>
            </form>
            <div class="forgot-password">
                <a href="/SukaInfo_app/forgot-password">Lupa Password?</a>
            </div>
        </div>
    </div>
   <script>
    $(document).ready(function () {
        $('#togglePassword').on('click', function () {
            const passwordInput = $('#password');
            const icon = $(this).find('i');

            // Toggle type
            const isPassword = passwordInput.attr('type') === 'password';
            passwordInput.attr('type', isPassword ? 'text' : 'password');

            // Toggle icon
            icon.toggleClass('fa-eye fa-eye-slash');
        });
    });
    $(document).ready(function () {
        $('#login-form').on('submit', function (e) {
            e.preventDefault();
             // Reset error dan tampilkan loading
            $('#error').addClass('invisible').text('');
            $('#loginButton').attr('disabled', true);
            $('.btn-text').text('Loading...');
            $('.spinner').removeClass('d-none');

            // Reset error box dulu sebelum request
            $('#error').addClass('invisible').text('');

            $.ajax({
                url: '/SukaInfo_app/login',
                method: 'POST',
                data: $(this).serialize(),
              
                success: function (response) {
                    try {
                        console.log("Raw response:", response);
                        if (response.success) {
                            setTimeout(function () {
                                window.location.href = "/SukaInfo_app/dashboard";
                            }, 1500);
                        } else {
                            $('#error')
                                .removeClass('invisible')
                                .text(response.message || 'Login gagal.');
                        }
                    } catch (e) {
                        console.error("Response parsing error:", e);
                        $('#error')
                            .removeClass('invisible')
                            .text("Respon server tidak valid.");
                    }
                },

                error: function (xhr, status, error) {
                    console.error(xhr.responseText); // untuk debugging
                    $('#error')
                        .removeClass('invisible')
                        .removeClass('invisible')
                        .text("Terjadi kesalahan server.");
                },
                complete: function () {
                    setTimeout(function () {
                        $('#loginButton').attr('disabled', false);
                        $('.btn-text').text('Login');
                        $('.spinner').addClass('d-none');
                    }, 1500); // Disamakan dengan delay redirect
                }
            });
        });
    });
    </script>

</body>
</html>