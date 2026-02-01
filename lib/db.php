<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $db = config_get('db', []);
    $dsn = (string)($db['dsn'] ?? '');
    $user = (string)($db['user'] ?? '');
    $password = (string)($db['password'] ?? '');
    $options = $db['options'] ?? [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $exception) {
        throw new RuntimeException('Database connection failed.', 0, $exception);
    }

    return $pdo;
}

function now(): string
{
    return date('Y-m-d H:i:s');
}

function log_message(string $message): void
{
    $dir = __DIR__ . '/../logs';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $path = $dir . '/app.log';
    $line = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $message);
    file_put_contents($path, $line, FILE_APPEND);
}
