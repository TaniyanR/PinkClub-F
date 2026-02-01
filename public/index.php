<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/repository.php';

$q = trim((string)($_GET['q'] ?? ''));

try {
    if ($q !== '' && function_exists('search_items')) {
        // もし repository.php に search_items($q, $limit) があるなら検索優先
        $new3 = search_items($q, 3);
        $new10 = search_items($q, 10);
        $pickup10 = search_items($q, 10);
    } else {
        $new3 = fetch_items('date_published DESC', 3);
        $new10 = fetch_items('date_published DESC', 10);
        $pickup10 = fetch_items('RAND()', 10);
    }
} catch (Throwable $e) {
    // 画面を真っ白にしない
    if (function_exists('log_message')) {
        log_message('index.php failed: ' . $e->getMessage());
    }
    $new3 = [];
    $new10 = [];
    $pickup10 = [];
}

include __DIR__ . '/partials/header.php';
?>
<main>
    <p>
        <a href="/actresses.php">女優一覧</a> |
        <a href="/genres.php">ジャンル一覧</a> |
        <a href="/makers.php">メーカー一覧</a> |
        <a href="/series.php">シリーズ一覧</a>
    </p>

    <?php if ($q !== '') : ?>
        <div class="admin-card">
            <p>検索: <?php echo htmlspecialchars($q, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endif; ?>

    <?php
    $items = $new3;
    include __DIR__ . '/partials/block_new3.php';
    ?>

    <?php
    $railTitle = '新着レール';
    $railItems = $new10;
    include __DIR__ . '/partials/block_rail.php';
    ?>

    <?php
    $railTitle = 'ピックアップレール';
    $railItems = $pickup10;
    include __DIR__ . '/partials/block_rail.php';
    ?>
</main>

<?php include __DIR__ . '/partials/sidebar.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
