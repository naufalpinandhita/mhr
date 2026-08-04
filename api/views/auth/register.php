<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <div class="container">
        <h1>Daftar</h1>

        <?php $success = flash_get('success'); if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>
        <?php $error = flash_get('error'); if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="process/auth/register.php">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?= old('username') ?>" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" minlength="8" required>
            </div>

            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
    </div>
</body>
</html>
