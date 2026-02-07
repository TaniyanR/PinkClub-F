<?php
declare(strict_types=1);

require_once __DIR__ . '/../../lib/config.php';

$siteTitle = (string) config_get('site.title', 'PinkClub-FANZA');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/assets/css/common.css">
    <?php if (isset($pageStyles) && is_array($pageStyles)) : ?>
        <?php foreach ($pageStyles as $stylePath) : ?>
            <link rel="stylesheet" href="<?php echo htmlspecialchars((string) $stylePath, ENT_QUOTES, 'UTF-8'); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
<header class="site-header">
    <div class="site-header__inner">
        <div class="site-header__brand">
            <a class="site-header__title" href="/">
                <?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <div class="site-header__note"><strong>当サイトはアフィリエイト広告を使用しています。</strong></div>
        </div>
        <div class="site-header__ad" aria-label="広告枠">
            <div class="ad-box ad-box--header">728x90</div>
        </div>
    </div>
</header>
<div class="site-body">
