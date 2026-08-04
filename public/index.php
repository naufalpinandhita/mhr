<?php
require_once __DIR__ . '/../api/config/app.php';
require_once __DIR__ . '/../api/helpers/functions.php';

$user = auth_user();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <div class="container">
        <h1>Halo dari Docker!</h1>

        <?php $success = flash_get('success'); if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>
        <?php $error = flash_get('error'); if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <?php if (auth_check()): ?>
            <p>Selamat datang, <strong><?= e($user['username']) ?></strong>! (Role: <?= e($user['role']) ?>)</p>
            <p><a href="process/auth/logout.php">Logout</a></p>
        <?php else: ?>
            <p>
                <a href="login.php">Login</a> | 
                <a href="register.php">Register</a>
            </p>
        <?php endif; ?>
    </div>
</body>
</html>
