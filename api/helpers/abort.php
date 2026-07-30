<?php
function abort (int $code = 404, string $message = 'Halaman tidak ditemukan'): void {
    http_response_code($code);
    require ROOT_DIR . '/views/errors/' . $code . '.php';
}