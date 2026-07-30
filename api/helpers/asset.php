<?php
    function asset(string $path): string {
        return BASE_URL . 'public/' . ltrim($path, '/');
    }