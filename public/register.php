<?php
require_once __DIR__ . '/../api/config/app.php';
require_once __DIR__ . '/../api/helpers/functions.php';

require_guest();
require API_DIR . '/views/auth/register.php';
