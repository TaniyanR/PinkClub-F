<?php
require_once __DIR__ . '/../lib/repository.php';

$cid = $_GET['cid'] ?? '';
$item = $cid ? fetch_item_by_content_id($cid) : null;

include __DIR__ . '/partials/header.php';
?>
<main>
    <?php if ($item) : ?>
        <h1><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div class="detail-card">
            <?php if (!empty($item['image_large']) || !empty($item['image_small'])) : ?>
                <img src="<?php echo htmlspecialchars($item['image_large'] ?: $item['image_small'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php endif; ?>
            <div class="detail-meta">
                <p>発売日: <?php echo htmlspecialchars($item['date_published'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                <p>価格: <?php echo htmlspecialchars((string)($item['price_min'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
                <p><a href="<?php echo htmlspecialchars($item['affiliate_url'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>">アフィリエイトURL</a></p>
            </div>
        </div>
    <?php else : ?>
        <div class="notice">該当する作品が見つかりませんでした。</div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
