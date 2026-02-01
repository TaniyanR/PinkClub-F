<?php
declare(strict_types=1);

return [
    'site' => [
        'title' => 'PinkClub-F',
        // 例: 'https://example.com'（末尾スラッシュなし）
        'base_url' => '',
    ],

    'db' => [
        // DSN方式（PDOでそのまま使える）
        // ※ 本番の認証情報は config.local.php で上書き推奨
        'dsn' => 'mysql:host=127.0.0.1;dbname=pinkclub_f;charset=utf8mb4',
        'user' => 'root',
        'password' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // MySQL向け：本物のプリペアを使用
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],

    // DMM/FANZA API（認証情報は config.local.php で上書き前提）
    'dmm_api' => [
        'api_id' => '',
        'affiliate_id' => '',
        'site' => 'FANZA',
        'service' => 'digital',
        'floor' => 'videoa',
    ],
];
