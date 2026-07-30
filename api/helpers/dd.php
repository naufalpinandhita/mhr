<?php
function dd($value): void {
    echo '<pre style="background:#1e1e1e;color:#00ff00;padding:16px;font-size:14px;border-radius:8px;overflow:auto;">';
    if (is_array($value) || is_object($value)) {
        print_r($value);
    } else {
        var_dump($value);
    }
    echo '</pre>';
    die;
}