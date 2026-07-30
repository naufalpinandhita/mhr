<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../services/AniListService.php';

class ProfileService {
    public static function getUserProfile($userIdentifier, int $limit = 10, int $offset = 0): ?array {
        if (is_int($userIdentifier) || ctype_digit((string)$userIdentifier)) {
            $user = User::findById((int)$userIdentifier);
        } else {
            $user = User::findByUsername((string)$userIdentifier);
        }

        if (!$user) {
            return null;
        }

        $userId = (int)$user['id'];
        $stats = Review::getStatsByUserId($userId);
        $reviews = Review::getByUserId($userId, $limit, $offset);

        // Ambil ID anime secara batch untuk menghindari N+1 query
        $animeIds = array_map(function ($review) {
            return (int)$review['anilist_id'];
        }, $reviews);

        $animeMap = AniListService::getAnimeByIds($animeIds);

        $enrichedReviews = array_map(function ($review) use ($animeMap) {
            $anilistId = (int)$review['anilist_id'];
            $anime = $animeMap[$anilistId] ?? null;

            return [
                'id' => (int)$review['id'],
                'anilist_id' => $anilistId,
                'rating' => (int)$review['rating'],
                'review_text' => $review['review_text'],
                'created_at' => $review['created_at'],
                'updated_at' => $review['updated_at'],
                'anime' => $anime ? [
                    'title' => $anime['title'] ?? null,
                    'cover_image' => $anime['coverImage'] ?? null,
                    'banner_image' => $anime['bannerImage'] ?? null,
                ] : null,
            ];
        }, $reviews);

        return [
            'user' => [
                'id' => $userId,
                'username' => $user['username'],
                'email' => $user['email'],
                'bio' => $user['bio'],
                'avatar' => $user['avatar'],
                'role' => $user['role'],
                'created_at' => $user['created_at'],
            ],
            'stats' => [
                'total_reviews' => $stats['total_reviews'],
                'average_rating' => $stats['average_rating'],
            ],
            'pagination' => [
                'total' => $stats['total_reviews'],
                'limit' => $limit,
                'offset' => $offset,
            ],
            'reviews' => $enrichedReviews,
        ];
    }
}
