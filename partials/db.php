<?php

declare(strict_types=1);

require_once __DIR__ . '/../lib/config.php';

function get_config(): array
{
    return config();
}

function get_pdo(): PDO
{
    $db = config_get('db', []);
    $dsn = $db['dsn'] ?? sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $db['host'] ?? '127.0.0.1',
        $db['name'] ?? '',
        $db['charset'] ?? 'utf8mb4'
    );

    $options = $db['options'] ?? [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    return new PDO($dsn, $db['user'] ?? '', $db['password'] ?? ($db['pass'] ?? ''), $options);
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
