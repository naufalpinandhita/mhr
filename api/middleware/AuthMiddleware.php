<?php

class AuthMiddleware {
    public static function check(): bool {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }

    public static function requireAuth(): void {
        if (!self::check()) {
            flash('error', 'Silakan login terlebih dahulu');
            redirect(BASE_URL . 'views/login.php');
        }
    }

    public static function requireGuest(): void {
        if (self::check()) {
            redirect(BASE_URL . 'index.php');
        }
    }

    public static function requireAdmin(): void {
        self::requireAuth();
        
        $user = self::user();
        if (($user['role'] ?? '') !== 'admin') {
            flash('error', 'Akses ditolak. Anda bukan admin.');
            redirect(BASE_URL . 'index.php');
        }
    }
}
