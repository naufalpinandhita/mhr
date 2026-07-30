<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../services/ProfileService.php';

header('Content-Type: application/json');

$userId = filter_var($_GET['user_id'] ?? null, FILTER_VALIDATE_INT);
$username = trim($_GET['username'] ?? '');

$identifier = null;

if ($userId) {
    $identifier = $userId;
} elseif ($username !== '') {
    $identifier = $username;
} elseif (auth_check()) {
    $identifier = (int)$_SESSION['user_id'];
} else {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Anda belum login. Silakan login untuk melihat profil Anda.'
    ]);
    exit;
}

$page = max(1, filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT) ?: 1);
$limit = max(1, min(50, filter_var($_GET['limit'] ?? 10, FILTER_VALIDATE_INT) ?: 10));
$offset = ($page - 1) * $limit;

$profileData = ProfileService::getUserProfile($identifier, $limit, $offset);

if (!$profileData) {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'User tidak ditemukan'
    ]);
    exit;
}

echo json_encode([
    'status' => 'success',
    'data' => $profileData
]);
