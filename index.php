<?php
define('BASE_URL', '/SukaInfo_app'); // <- sesuaikan dengan nama folder kamu
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/routes/web.php';
