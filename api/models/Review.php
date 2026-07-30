<?php
require_once __DIR__ . '/../config/database.php';

class Review {
    public static function findById(int $id): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT r.*, u.username, u.avatar FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findByUserAndAnime(int $userId, int $anilistId): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM reviews WHERE user_id = ? AND anilist_id = ? LIMIT 1');
        $stmt->execute([$userId, $anilistId]);
        return $stmt->fetch() ?: null;
    }

    public static function upsert(array $data): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            INSERT INTO reviews (user_id, anilist_id, rating, review_text)
            VALUES (:user_id, :anilist_id, :rating, :review_text)
            ON DUPLICATE KEY UPDATE
                rating = VALUES(rating),
                review_text = VALUES(review_text),
                updated_at = CURRENT_TIMESTAMP
        ');
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'anilist_id' => $data['anilist_id'],
            'rating' => $data['rating'],
            'review_text' => $data['review_text'],
        ]);
    }

    public static function delete(int $id, int $userId, bool $isAdmin = false): bool {
        $pdo = Database::getInstance();
        if ($isAdmin) {
            $stmt = $pdo->prepare('DELETE FROM reviews WHERE id = ?');
            return $stmt->execute([$id]);
        }
        $stmt = $pdo->prepare('DELETE FROM reviews WHERE id = ? AND user_id = ?');
        return $stmt->execute([$id, $userId]);
    }

    public static function getByAnimeId(int $anilistId, int $limit = 10, int $offset = 0): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT r.*, u.username, u.avatar
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.anilist_id = ?
            ORDER BY r.created_at DESC
            LIMIT ? OFFSET ?
        ');
        $stmt->bindValue(1, $anilistId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getByUserId(int $userId, int $limit = 10, int $offset = 0): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT r.*
            FROM reviews r
            WHERE r.user_id = ?
            ORDER BY r.created_at DESC
            LIMIT ? OFFSET ?
        ');
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function countByUserId(int $userId): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM reviews WHERE user_id = ?');
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }

    public static function getStatsByUserId(int $userId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT 
                COUNT(*) as total_reviews,
                COALESCE(ROUND(AVG(rating), 1), 0) as average_rating
            FROM reviews
            WHERE user_id = ?
        ');
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return [
            'total_reviews' => (int) ($result['total_reviews'] ?? 0),
            'average_rating' => (float) ($result['average_rating'] ?? 0),
        ];
    }

    public static function getSummaryByAnimeId(int $anilistId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT 
                COUNT(*) as total_reviews,
                COALESCE(ROUND(AVG(rating), 1), 0) as average_rating
            FROM reviews
            WHERE anilist_id = ?
        ');
        $stmt->execute([$anilistId]);
        $result = $stmt->fetch();
        return [
            'total_reviews' => (int) ($result['total_reviews'] ?? 0),
            'average_rating' => (float) ($result['average_rating'] ?? 0),
        ];
    }
}
