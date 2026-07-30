<?php

class AniListService {
    private static string $apiUrl = 'https://graphql.anilist.co';

    private static function executeQuery(string $query, array $variables = []): ?array {
        $ch = curl_init(self::$apiUrl);
        $payload = json_encode([
            'query' => $query,
            'variables' => $variables
        ]);

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'User-Agent: Mozilla/5.0'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error || !$response) {
            return null;
        }

        $decoded = json_decode($response, true);
        return $decoded['data'] ?? null;
    }

    public static function getAnimeById(int $id): ?array {
        $query = '
            query ($id: Int) {
                Media (id: $id, type: ANIME) {
                    id
                    title {
                        romaji
                        english
                        native
                        userPreferred
                    }
                    type
                    format
                    status
                    description
                    startDate { year month day }
                    endDate { year month day }
                    season
                    seasonYear
                    episodes
                    duration
                    coverImage { extraLarge large medium color }
                    bannerImage
                    genres
                    averageScore
                    meanScore
                    popularity
                    favourites
                    isAdult
                    siteUrl
                    trailer { id site thumbnail }
                    characters (perPage: 10) {
                        edges {
                            role
                            node {
                                id
                                name { full native }
                                image { medium }
                            }
                        }
                    }
                    staff (perPage: 10) {
                        edges {
                            role
                            node {
                                id
                                name { full native }
                                image { medium }
                            }
                        }
                    }
                }
            }
        ';

        $data = self::executeQuery($query, ['id' => $id]);
        return $data['Media'] ?? null;
    }

    public static function getTrendingAnime(int $page = 1, int $perPage = 10): array {
        $query = '
            query ($page: Int, $perPage: Int) {
                Page (page: $page, perPage: $perPage) {
                    pageInfo {
                        total
                        currentPage
                        lastPage
                        hasNextPage
                        perPage
                    }
                    media (type: ANIME, sort: TRENDING_DESC) {
                        id
                        title {
                            romaji
                            english
                            native
                            userPreferred
                        }
                        format
                        status
                        episodes
                        seasonYear
                        coverImage { extraLarge large medium color }
                        bannerImage
                        genres
                        averageScore
                        popularity
                        isAdult
                    }
                }
            }
        ';

        $data = self::executeQuery($query, ['page' => $page, 'perPage' => $perPage]);
        return $data['Page'] ?? [];
    }

    public static function searchAnime(string $keyword, int $page = 1, int $perPage = 10): array {
        $query = '
            query ($search: String, $page: Int, $perPage: Int) {
                Page (page: $page, perPage: $perPage) {
                    pageInfo {
                        total
                        currentPage
                        lastPage
                        hasNextPage
                        perPage
                    }
                    media (search: $search, type: ANIME, sort: POPULARITY_DESC) {
                        id
                        title {
                            romaji
                            english
                            native
                            userPreferred
                        }
                        format
                        status
                        episodes
                        seasonYear
                        coverImage { extraLarge large medium color }
                        bannerImage
                        genres
                        averageScore
                        popularity
                        isAdult
                    }
                }
            }
        ';

        $data = self::executeQuery($query, ['search' => $keyword, 'page' => $page, 'perPage' => $perPage]);
        return $data['Page'] ?? [];
    }
}
