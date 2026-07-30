<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . 'views/login.php');
}

if (!csrf_verify($_POST['csrf_token'] ?? '')) { 
    flash('error', 'Token tidak valid');
    redirect(BASE_URL . 'views/login.php');
}

$username   = trim($_POST['username'] ?? '');
$password   = $_POST['password'] ?? '';

if ($username === '' || $password === ''){
    $_SESSION['old'] = $_POST;
    flash('error', 'Isi semua kolom');
    redirect(BASE_URL . 'views/login.php');
}

$user = User::findByUsername($username);
if (!$user){
    $_SESSION['old'] = $_POST;
    flash('error', 'Username tidak ditemukan');
    redirect(BASE_URL . 'views/login.php');
}

if (!User::verifyPassword($password, $user['password'])){
    flash('error', 'Password salah');
    redirect(BASE_URL . 'views/login.php');
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user'] = [
    'id'        => $user['id'],
    'username'  => $user['username'],
    'email'     => $user['email'],
    'role'      => $user['role'],
];

csrf_regenerate();

flash('success', 'Berhasil login');
redirect(BASE_URL . 'index.php');
