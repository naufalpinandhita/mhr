<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../helpers/functions.php';

unset($_SESSION['user_id']);
unset($_SESSION['user']);

flash('success', 'Berhasil Logout');

redirect(BASE_URL . 'views/login.php');