<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . 'register.php');
}

if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    flash('error', 'Token tidak valid');
    redirect(BASE_URL . 'register.php');
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $email === '' || $password === ''){
    $_SESSION['old'] = $_POST;
    flash('error', 'Semua field wajib diisi');
    redirect(BASE_URL . 'register.php');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['old'] = $_POST;
    flash('error', 'Email tidak valid');
    redirect(BASE_URL . 'register.php');
}

if (strlen($password) < 8){
    $_SESSION['old'] = $_POST;
    flash('error', 'Password minimal 8 karakter');
    redirect(BASE_URL . 'register.php');
}

if (User::findByEmail($email)){
    $_SESSION['old'] = $_POST;
    flash('error', 'Email sudah terdaftar');
    redirect(BASE_URL . 'register.php');
}

if (User::findByUsername($username)){
    $_SESSION['old'] = $_POST;
    flash('error', 'Username sudah digunakan');
    redirect(BASE_URL . 'register.php');
}

$userId = User::create([
    'username'  => $username,
    'email'     => $email,
    'password'  => $password,
]);

$_SESSION['user_id'] = $userId;
csrf_regenerate();
flash('success', 'Registrasi berhasil!');
redirect(BASE_URL . 'login.php');

