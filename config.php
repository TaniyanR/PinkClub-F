<?php

declare(strict_types=1);

return [
    'db' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=pinkclub_f;charset=utf8mb4',
        'user' => 'root',
        'password' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
    ],
    'site' => [
        'title' => 'PinkClub-F',
    ],
    'dmm_api' => [
        'api_id' => 'YOUR_API_ID',
        'affiliate_id' => 'YOUR_AFFILIATE_ID',
        'site' => 'FANZA',
        'service' => 'digital',
        'floor' => 'videoa',
        'hits' => 20,
        'sort' => 'date',
        'output' => 'json',
    ],
];
