<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../models/Review.php';

AuthMiddleware::requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . 'index.php');
}

if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    flash('error', 'Token tidak valid');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

$reviewId = filter_var($_POST['review_id'] ?? null, FILTER_VALIDATE_INT);
$userId = $_SESSION['user_id'];
$currentUser = AuthMiddleware::user();
$isAdmin = ($currentUser['role'] ?? '') === 'admin';

if (!$reviewId) {
    flash('error', 'ID Ulasan tidak valid');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

$success = Review::delete($reviewId, $userId, $isAdmin);

if ($success) {
    flash('success', 'Ulasan berhasil dihapus');
} else {
    flash('error', 'Gagal menghapus ulasan atau ulasan tidak ditemukan');
}

redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
