<?php

// ─── Timezone ───
date_default_timezone_set('Asia/Jakarta');

// ─── Error Reporting ───
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// ─── Session ───
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', '1');
}

session_name('MHR_SESSION');
session_start();

// ─── Base URL ───
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $protocol . '://' . $host . '/');

// ─── Paths ───
define('ROOT_DIR', dirname(__DIR__, 2));
define('API_DIR', ROOT_DIR . '/api');

// ─── Simple Autoloader ───
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = API_DIR . '/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
