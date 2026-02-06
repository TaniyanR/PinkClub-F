<?php
declare(strict_types=1);

$q = trim((string)($_GET['q'] ?? ''));

$buildItems = static function (int $count, string $label): array {
    $items = [];
    for ($i = 1; $i <= $count; $i++) {
        $title = sprintf('%s %02d', $label, $i);
        $items[] = [
            'title' => $title,
            'meta' => '更新日: 2024-03-01',
            'image' => 'https://placehold.co/640x360?text=' . rawurlencode($title),
        ];
    }
    return $items;
};

$newCards = $buildItems(3, '新着作品');
$newRail = $buildItems(15, '新着レール');
$pickupRail = $buildItems(15, 'ピックアップ');
$actresses = $buildItems(6, '女優');
$genreRails = [
    ['title' => 'ジャンル レール 1', 'items' => $buildItems(15, 'ジャンル')],
    ['title' => 'ジャンル レール 2', 'items' => $buildItems(15, 'ジャンル')],
    ['title' => 'ジャンル レール 3', 'items' => $buildItems(15, 'ジャンル')],
];
$seriesRails = [
    ['title' => 'シリーズ レール 1', 'items' => $buildItems(15, 'シリーズ')],
    ['title' => 'シリーズ レール 2', 'items' => $buildItems(15, 'シリーズ')],
    ['title' => 'シリーズ レール 3', 'items' => $buildItems(15, 'シリーズ')],
];
$makerRails = [
    ['title' => 'メーカー レール 1', 'items' => $buildItems(15, 'メーカー')],
    ['title' => 'メーカー レール 2', 'items' => $buildItems(15, 'メーカー')],
    ['title' => 'メーカー レール 3', 'items' => $buildItems(15, 'メーカー')],
];

include __DIR__ . '/partials/header.php';
?>
<div class="search-bar">
    <form method="get" action="/index.php">
        <input type="text" name="q" placeholder="作品名・女優名で検索" value="<?php echo htmlspecialchars($q, ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">検索</button>
    </form>
</div>

<div class="layout">
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="main-content">
        <?php if ($q !== '') : ?>
            <section class="block">
                <div class="section-head">
                    <h2 class="section-title">検索中</h2>
                    <span class="section-sub">キーワード: <?php echo htmlspecialchars($q, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <p>検索結果はダミー表示です。</p>
            </section>
        <?php endif; ?>

        <!-- partial: block_new -->
        <section class="block block-new">
            <div class="section-head">
                <h2 class="section-title">新着</h2>
                <span class="section-sub">人気順で表示する想定</span>
            </div>
            <div class="card-grid">
                <?php foreach ($newCards as $item) : ?>
                    <article class="card">
                        <div class="card-media" style="background-image:url('<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                        <div class="card-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="card-meta"><?php echo htmlspecialchars($item['meta'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="card-actions">詳しくみる</div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="rail" aria-label="新着レール">
                <?php foreach ($newRail as $item) : ?>
                    <article class="rail-item">
                        <div class="card-media" style="background-image:url('<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                        <div class="card-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="card-meta"><?php echo htmlspecialchars($item['meta'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- partial: block_pickup -->
        <section class="block block-pickup">
            <div class="section-head">
                <h2 class="section-title">ピックアップ</h2>
                <span class="section-sub">注目作品をランダム表示</span>
            </div>
            <div class="card-grid">
                <?php foreach ($newCards as $item) : ?>
                    <article class="card">
                        <div class="card-media" style="background-image:url('<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                        <div class="card-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="card-meta"><?php echo htmlspecialchars($item['meta'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="card-actions">詳しくみる</div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="rail" aria-label="ピックアップレール">
                <?php foreach ($pickupRail as $item) : ?>
                    <article class="rail-item">
                        <div class="card-media" style="background-image:url('<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                        <div class="card-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="card-meta"><?php echo htmlspecialchars($item['meta'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- partial: block_actress -->
        <section class="block block-actress">
            <div class="section-head">
                <h2 class="section-title">女優</h2>
                <span class="section-sub">ランダム6枠</span>
            </div>
            <div class="actress-grid">
                <?php foreach ($actresses as $item) : ?>
                    <article class="actress-card">
                        <div class="card-media" style="background-image:url('<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                        <div class="card-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- partial: block_genre -->
        <section class="block block-genre">
            <div class="section-head">
                <h2 class="section-title">ジャンル</h2>
                <span class="section-sub">3段レール</span>
            </div>
            <?php foreach ($genreRails as $rail) : ?>
                <div class="tag-rail" aria-label="<?php echo htmlspecialchars($rail['title'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php foreach ($rail['items'] as $item) : ?>
                        <div class="tag-card">
                            <div class="tag-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="tag-meta">15件を想定</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- partial: block_series -->
        <section class="block block-series">
            <div class="section-head">
                <h2 class="section-title">シリーズ</h2>
                <span class="section-sub">3段レール</span>
            </div>
            <?php foreach ($seriesRails as $rail) : ?>
                <div class="tag-rail" aria-label="<?php echo htmlspecialchars($rail['title'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php foreach ($rail['items'] as $item) : ?>
                        <div class="tag-card">
                            <div class="tag-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="tag-meta">15件を想定</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- partial: block_maker -->
        <section class="block block-maker">
            <div class="section-head">
                <h2 class="section-title">メーカー</h2>
                <span class="section-sub">3段レール</span>
            </div>
            <?php foreach ($makerRails as $rail) : ?>
                <div class="tag-rail" aria-label="<?php echo htmlspecialchars($rail['title'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php foreach ($rail['items'] as $item) : ?>
                        <div class="tag-card">
                            <div class="tag-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="tag-meta">15件を想定</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
