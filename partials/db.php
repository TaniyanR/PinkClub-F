<?php

declare(strict_types=1);

require_once __DIR__ . '/../lib/config.php';

function get_config(): array
{
    return config();
}

function get_pdo(): PDO
{
    $config = get_config();
    $db = $config['db'];

    return new PDO($db['dsn'], $db['user'], $db['password'], $db['options']);
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
