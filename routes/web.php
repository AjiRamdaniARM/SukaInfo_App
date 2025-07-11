<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

require_once __DIR__ . '/../controllers/ArtikelController.php';
require_once __DIR__ . '/../config/config.php';

$artikelController = new ArtikelController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/SukaInfo_app/artikel/store') {
    $artikelController->store();
}



// Routing GET (menampilkan halaman)
if ($method === 'GET') {
    if ($uri === '/SukaInfo_app/deleteArtikel') {
        $artikelController->delete();
    }
    if ($uri === '/SukaInfo_app/editArtikel') {
        require_once __DIR__ . '/../controllers/ArtikelController.php';
        $controller = new ArtikelController($conn);
        $controller->edit();
        return;
    }
    $routes = [
        '/SukaInfo_app/' => 'views/home/index.php',
        '/SukaInfo_app/login' => 'views/auth/login.php',
        '/SukaInfo_app/forgot-password' => 'views/auth/forgoPassword.php',
        // === route admin === //
        '/SukaInfo_app/dashboard' => 'views/admin/index.php',
        // === route artikel === //
        '/SukaInfo_app/createArtikel' => 'views/admin/pages/artikel/create.php',
        // === route event === //
        '/SukaInfo_app/createEvent' => 'views/admin/pages/artikel/create.php',

    ];

    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
    }
}


// Routing POST (menangani login AJAX)
if ($uri === '/SukaInfo_app/login' && $method === 'POST') {
    ob_start(); // Start output buffer
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    define('APP_RUNNING', true);
    require_once __DIR__ . '/../config/config.php';

    header('Content-Type: application/json');

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $conn->prepare("SELECT * FROM pengguna WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email'];

            ob_clean(); // Hapus output buffer sebelum kirim JSON
            echo json_encode(['success' => true]);
        } else {
            ob_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Email atau password salah'
            ]);
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
        ob_clean();
        echo json_encode([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem.'
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
