<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Routing GET (menampilkan halaman)
if ($method === 'GET') {
    $routes = [
        '/SukaInfo_app/' => 'views/home/index.php',
        '/SukaInfo_app/dashboard' => 'views/admin/index.php',
        '/SukaInfo_app/login' => 'views/auth/login.php',
        '/SukaInfo_app/register' => 'views/auth/register.php',
    ];

    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
    }
}

// Routing POST (menangani login AJAX)
elseif ($uri === '/SukaInfo_app/login' && $method === 'POST') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    header('Content-Type: application/json');

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email === 'admin@gmail.com' && $password === 'admin') {
        $_SESSION['user'] = $email;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Email atau password salah'
        ]);
    }

    exit;
}


// Routing Logout
elseif ($uri === '/SukaInfo_app/logout') {
    session_start();
    session_destroy();
    header('Location: /SukaInfo_app/login');
    exit;
}

// Fallback untuk selain yang ditentukan
else {
    http_response_code(404);
    echo "404 - Halaman tidak ditemukan";
}
