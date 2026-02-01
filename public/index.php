<?php

declare(strict_types=1);

require __DIR__ . '/../partials/db.php';

$config = get_config();
$siteTitle = $config['site']['title'];
$pageTitle = $siteTitle . ' | 記事一覧';

$pdo = get_pdo();
$stmt = $pdo->prepare('SELECT id, title, affiliate_url, image_url, release_date FROM articles ORDER BY release_date DESC, id DESC LIMIT 20');
$stmt->execute();
$articles = $stmt->fetchAll();

require __DIR__ . '/../partials/header.php';
?>
<div class="layout">
    <section>
        <h1>記事一覧</h1>
        <?php if (!$articles): ?>
            <p>まだ記事がありません。APIインポートを実行してください。</p>
        <?php endif; ?>
        <?php foreach ($articles as $article): ?>
            <article class="card">
                <?php if (!empty($article['image_url'])): ?>
                    <a href="/article.php?id=<?php echo e((string) $article['id']); ?>">
                        <img src="<?php echo e($article['image_url']); ?>" alt="<?php echo e($article['title']); ?>">
                    </a>
                <?php endif; ?>
                <h2>
                    <a href="/article.php?id=<?php echo e((string) $article['id']); ?>">
                        <?php echo e($article['title']); ?>
                    </a>
                </h2>
                <div class="meta">発売日: <?php echo e($article['release_date'] ?? '未設定'); ?></div>
                <p><a href="<?php echo e($article['affiliate_url']); ?>" target="_blank" rel="noopener">商品ページへ</a></p>
            </article>
        <?php endforeach; ?>
    </section>
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>
</div>
<?php
require __DIR__ . '/../partials/footer.php';
