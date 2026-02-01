<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/config.php';
require_once __DIR__ . '/../lib/repository.php';

$latestItems = fetch_items('date_published DESC', 12);
$featuredItems = fetch_items('date_published DESC', 6);

include __DIR__ . '/partials/header.php';
?>
<main>
    <h1><?php echo htmlspecialchars((string)config_get('site.title', 'PinkClub-F'), ENT_QUOTES, 'UTF-8'); ?></h1>

    <h2 class="section-title">新着作品</h2>
    <div class="rail">
        <?php foreach ($latestItems as $item) : ?>
            <div class="rail-item">
                <?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                <div><a href="/item.php?cid=<?php echo urlencode((string)($item['content_id'] ?? '')); ?>">詳細</a></div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="section-title">おすすめ</h2>
    <div class="rail">
        <?php foreach ($featuredItems as $item) : ?>
            <div class="rail-item">
                <?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                <div><a href="/item.php?cid=<?php echo urlencode((string)($item['content_id'] ?? '')); ?>">詳細</a></div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
