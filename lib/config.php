<?php
declare(strict_types=1);

function config(): array
{
    static $config = null;

    if ($config === null) {
        $config = require __DIR__ . '/../config.php';
        date_default_timezone_set('Asia/Tokyo');
    }

    return $config;
}

function config_get(string $key, $default = null)
{
    $config = config();
    $segments = explode('.', $key);
    $value = $config;

    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}
