<?php
    function old(string $key, string $default = ''): string {
        $value = $_SESSION['old'][$key] ?? $default;
        unset($_SESSION['old'][$key]);
        return htmlspecialchars($value, ENT_QUOTES);
    }