<?php 
require_once __DIR__ . '/../config/database.php';

class User {
    public static function findByEmail(string $email): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function findByUsername(string $username): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare(
            'INSERT INTO users (username, email, password, bio, avatar, role) VALUES (:username, :email, :password, :bio, :avatar, :role)'
        );
        $stmt->execute([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'bio'      => $data['bio'] ?? '',
            'avatar'   => $data['avatar'] ?? '',
            'role'     => $data['role'] ?? 'user',
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function verifyPassword(string $plain, string $hash): bool {
        return password_verify($plain, $hash);
    }
}