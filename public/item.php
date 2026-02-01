<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/repository.php';

$cid = $_GET['cid'] ?? '';
$item = $cid ? fetch_item_by_content_id($cid) : null;
$notFound = false;

if (!$item) {
    $notFound = true;
    http_response_code(404);
}

include __DIR__ . '/partials/header.php';
?>
<main>
    <?php if ($notFound) : ?>
        <h1>作品が見つかりませんでした。</h1>
        <p>指定されたCIDの作品がありません。</p>
    <?php else : ?>
        <h1><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <p>発売日: <?php echo htmlspecialchars($item['date_published'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
        <p>価格: <?php echo htmlspecialchars((string)($item['price_min'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
        <p><a href="<?php echo htmlspecialchars($item['affiliate_url'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>">アフィリエイトURL</a></p>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
