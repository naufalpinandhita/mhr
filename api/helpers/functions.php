<?php
    require_once __DIR__ . '/abort.php';
    require_once __DIR__ . '/asset.php';
    require_once __DIR__ . '/csrf.php';
    require_once __DIR__ . '/dd.php';
    require_once __DIR__ . '/escape.php';
    require_once __DIR__ . '/flash.php';
    require_once __DIR__ . '/old.php';
    require_once __DIR__ . '/redirect.php';
    require_once __DIR__ . '/../middleware/AuthMiddleware.php';

    function auth_check(): bool {
        return AuthMiddleware::check();
    }

    function auth_user(): ?array {
        return AuthMiddleware::user();
    }

    function require_auth(): void {
        AuthMiddleware::requireAuth();
    }

    function require_guest(): void {
        AuthMiddleware::requireGuest();
    }

