<?php

$siteTitle = $siteTitle ?? 'PinkClub-FANZA';
$pageTitle = $pageTitle ?? $siteTitle;
?><!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($pageTitle); ?></title>
    <style>
        body { font-family: "Helvetica Neue", Arial, sans-serif; margin: 0; color: #222; }
        header, footer { background: #111; color: #fff; padding: 12px 20px; }
        header .wrap, main .wrap, footer .wrap { max-width: 980px; margin: 0 auto; }
        header .bar { display: flex; justify-content: space-between; align-items: center; }
        header a { color: #fff; text-decoration: none; }
        main { padding: 20px; }
        .layout { display: grid; grid-template-columns: 1fr 280px; gap: 20px; }
        .card { border-bottom: 1px solid #ddd; padding-bottom: 12px; margin-bottom: 12px; }
        .card img { max-width: 100%; height: auto; display: block; }
        .meta { color: #666; font-size: 12px; }
        .sidebar { background: #f5f5f5; padding: 12px; }
        @media (max-width: 840px) {
            .layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<header>
    <div class="wrap bar">
        <div class="logo">
            <a href="/index.php"><?php echo e($siteTitle); ?></a>
        </div>
        <div class="right">Phase1: 記事一覧</div>
    </div>
</header>
<main>
    <div class="wrap">
