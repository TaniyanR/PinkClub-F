<?php
require_once __DIR__ . '/../lib/repository.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 50;
$offset = ($page - 1) * $limit;
$seriesList = fetch_series($limit, $offset, 'name');

include __DIR__ . '/partials/header.php';
?>
<main>
    <h1>シリーズ一覧</h1>

    <?php if (!$seriesList) : ?>
        <div class="notice">まだデータがありません。</div>
    <?php else : ?>
        <ul>
            <?php foreach ($seriesList as $series) : ?>
                <li>
                    <a href="/series_one.php?id=<?php echo urlencode((string)($series['id'] ?? 0)); ?>">
                        <?php echo htmlspecialchars($series['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="pagination">
            <a href="?page=<?php echo $page - 1; ?>">前へ</a>
            <a href="?page=<?php echo $page + 1; ?>">次へ</a>
        </div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
