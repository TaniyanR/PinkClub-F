<?php
declare(strict_types=1);

function config(): array
{
    if (isset($GLOBALS['__config_cache']) && is_array($GLOBALS['__config_cache'])) {
        return $GLOBALS['__config_cache'];
    }

    $base = require __DIR__ . '/../config.php';
    if (!is_array($base)) {
        $base = [];
    }
    $localPath = __DIR__ . '/../config.local.php';
    $local = [];
    if (is_file($localPath)) {
        $local = require $localPath;
    }
    if (!is_array($local)) {
        $local = [];
    }

    $GLOBALS['__config_cache'] = array_replace_recursive($base, $local);
    return $GLOBALS['__config_cache'];
}

function config_reset(): void
{
    unset($GLOBALS['__config_cache']);
}

function config_get(string $path, $default = null)
{
    $config = config();
    $segments = array_filter(explode('.', $path), 'strlen');
    $value = $config;

    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}
