<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../models/Review.php';
require_once __DIR__ . '/../../services/AniListService.php';

AuthMiddleware::requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . 'index.php');
}

if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    flash('error', 'Token tidak valid');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

$anilistId = filter_var($_POST['anilist_id'] ?? null, FILTER_VALIDATE_INT);
$rating = filter_var($_POST['rating'] ?? null, FILTER_VALIDATE_INT);
$reviewText = trim($_POST['review_text'] ?? '');
$userId = $_SESSION['user_id'];

if (!$anilistId) {
    flash('error', 'ID Anime tidak valid');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

$anime = AniListService::getAnimeById($anilistId);
if (!$anime) {
    flash('error', 'Anime tidak ditemukan di AniList');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

if (!$rating || $rating < 1 || $rating > 10) {
    flash('error', 'Rating harus berupa angka 1 sampai 10');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

if (mb_strlen($reviewText) < 10) {
    flash('error', 'Ulasan terlalu pendek (minimal 10 karakter)');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

if (mb_strlen($reviewText) > 200) {
    flash('error', 'Ulasan terlalu panjang (maksimal 200 karakter)');
    redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
}

$success = Review::upsert([
    'user_id' => $userId,
    'anilist_id' => $anilistId,
    'rating' => $rating,
    'review_text' => $reviewText,
]);

if ($success) {
    flash('success', 'Ulasan berhasil disimpan');
} else {
    flash('error', 'Gagal menyimpan ulasan');
}

redirect($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'index.php');
