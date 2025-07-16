<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

require_once __DIR__ . '/../controllers/ArtikelController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/PenggunaController.php';
require_once __DIR__ . '/../controllers/LowonganController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/EventController.php';
require_once __DIR__ . '/../controllers/RekomendasiController.php';
require_once __DIR__ . '/../config/config.php';

$artikelController = new ArtikelController($conn);
$DashboardController = new DashboardController($conn);
$HomeController = new HomeController($conn);
$PenggunaController = new PenggunaController($conn);
$LowonganController = new LowonganController($conn);
$EventController = new EventController($conn);
$RekomendasiController = new RekomendasiController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/SukaInfo_app/artikel/store') {
    $artikelController->store();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if ($path === '/SukaInfo_app/artikel/update') {
        $artikelController->update();
    } elseif ($path === '/SukaInfo_app/pengguna/update') {
        $PenggunaController->update();
    } elseif ($path === '/SukaInfo_app/Jobs/update') {
        $LowonganController->update();
    } elseif ($path === '/SukaInfo_app/pengguna/store') {
        $PenggunaController->store();
    } elseif ($path === '/SukaInfo_app/Jobs/store') {
        $LowonganController->store();
    } elseif ($path === '/SukaInfo_app/Event/store') {
        $EventController->store();
    } elseif ($path === '/SukaInfo_app/Event/update') {
        $EventController->update();
    } elseif ($path === '/SukaInfo_app/Rekomendasi/store') {
        $RekomendasiController->store();
    } elseif ($path === '/SukaInfo_app/Rekomendasi/update') {
        $RekomendasiController->update();
    }
}

// Routing GET (menampilkan halaman)
if ($method === 'GET') {

    switch ($uri) {
        // === Home ===
        case '/SukaInfo_app/':
            $controller = new HomeController($conn);
            $controller->index();
            break;

        // === jobs ===
        case '/SukaInfo_app/createJobs':
            require_once __DIR__ . '/../views/admin/pages/jobs/create.php';
            break;
        case '/SukaInfo_app/lowongan/edit':
            $controller = new LowonganController($conn);
            $controller->edit();
            break;
        case '/SukaInfo_app/jobs/delete':
            $controller = new LowonganController($conn);
            $controller->delete();
            break;
        case '/SukaInfo_app/jobs/detail':
            $controller = new LowonganController($conn);
            $controller->show();
            break;

        // === Artikel ===
        case '/SukaInfo_app/createArtikel':
            require_once __DIR__ . '/../views/admin/pages/artikel/create.php';
            break;

        case '/SukaInfo_app/editArtikel':
            $controller = new ArtikelController($conn);
            $controller->edit();
            break;

        case '/SukaInfo_app/deleteArtikel':
            $controller = new ArtikelController($conn);
            $controller->delete();
            break;

        case '/SukaInfo_app/deletePengguna':
            $controller = new PenggunaController($conn);
            $controller->delete();
            break;

        case '/SukaInfo_app/detailArtikel':
            $controller = new ArtikelController($conn);
            $controller->detail();
            break;

        // === Event ===
        case '/SukaInfo_app/createEvent':
            require_once __DIR__ . '/../views/admin/pages/event/create.php'; // <-- perbaiki path
            break;
        case '/SukaInfo_app/event/edit':
            $controller = new EventController($conn);
            $controller->edit();
            break;

        case '/SukaInfo_app/event/detail':
            $controller = new EventController($conn);
            $controller->detail();
            break;

        case '/SukaInfo_app/event/delete':
            $controller = new EventController($conn);
            $controller->delete();
            break;


        // === Dashboard ===
        case '/SukaInfo_app/dashboard':
            $controller = new DashboardController($conn);
            $controller->index();
            break;

        // === Rekomendasi ===
        case '/SukaInfo_app/rekomendasi/create':
            $controller = new RekomendasiController($conn);
            $controller->create(); // atau bisa dibuat method index() jika ingin tampilkan daftar pengguna
            break;
        case '/SukaInfo_app/rekomendasi/edit':
            $controller = new RekomendasiController($conn);
            $controller->edit(); // atau bisa dibuat method index() jika ingin tampilkan daftar pengguna
            break;
        case '/SukaInfo_app/rekomendasi/delete':
            $controller = new RekomendasiController($conn);
            $controller->delete(); // atau bisa dibuat method index() jika ingin tampilkan daftar pengguna
            break;

        // === Pengguna === 
        case '/SukaInfo_app/pengguna':
            $controller = new PenggunaController($conn);
            $controller->edit(); // atau bisa dibuat method index() jika ingin tampilkan daftar pengguna
            break;

        case '/SukaInfo_app/pengguna/create':
            require_once __DIR__ . '/../views/admin/pages/users/create.php'; // <-- perbaiki path
            break;

        // === Auth ===
        case '/SukaInfo_app/login':
            require_once __DIR__ . '/../views/auth/login.php';
            break;

        case '/SukaInfo_app/forgot-password':
            require_once __DIR__ . '/../views/auth/forgoPassword.php';
            break;

        // === Default ===
        default:
            http_response_code(404);
            echo "404 - Halaman tidak ditemukan";
            break;
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
