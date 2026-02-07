<?php
declare(strict_types=1);

$pageScripts = ['/assets/js/home.js'];

include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/nav_search.php';
?>
<div class="layout">
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="main-content">
        <section class="block">
            <div class="section-head">
                <h2 class="section-title">新着</h2>
                <span class="section-sub">最新の投稿を表示する想定</span>
            </div>
            <div class="product-grid product-grid--4" data-grid="new-top"></div>
            <div class="product-grid product-grid--6" data-grid="new-bottom"></div>
        </section>

        <section class="block">
            <div class="section-head">
                <h2 class="section-title">ピックアップ</h2>
                <span class="section-sub">アクセスが多い作品の想定</span>
            </div>
            <div class="product-grid product-grid--4" data-grid="pickup-top"></div>
            <div class="product-grid product-grid--6" data-grid="pickup-bottom"></div>
        </section>

        <section class="block">
            <div class="section-head">
                <h2 class="section-title">女優</h2>
                <span class="section-sub">注目の5名を表示</span>
            </div>
            <div class="actress-grid" data-grid="actress"></div>
        </section>

        <section class="block">
            <div class="section-head">
                <h2 class="section-title">シリーズ</h2>
                <span class="section-sub">3段シャッフル表示</span>
            </div>
            <div class="tile-rows" data-rows="series"></div>
        </section>

        <section class="block">
            <div class="section-head">
                <h2 class="section-title">メーカー</h2>
                <span class="section-sub">3段シャッフル表示</span>
            </div>
            <div class="tile-rows" data-rows="maker"></div>
        </section>

        <section class="block">
            <div class="section-head">
                <h2 class="section-title">レーベル</h2>
                <span class="section-sub">3段シャッフル表示</span>
            </div>
            <div class="tile-rows" data-rows="label"></div>
        </section>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
