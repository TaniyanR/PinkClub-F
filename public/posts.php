<?php
declare(strict_types=1);

$pageScripts = ['/assets/js/posts.js'];

include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/nav_search.php';
?>
<div class="layout">
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="main-content">
        <section class="block">
            <div class="section-head">
                <h1 class="section-title">記事一覧</h1>
                <span class="section-sub">商品カードはダミー表示です</span>
            </div>
            <div class="controls">
                <div class="controls__group">
                    <label>
                        並び替え
                        <select>
                            <option>人気（想定）</option>
                            <option>新着（想定）</option>
                        </select>
                    </label>
                    <label>
                        表示件数
                        <select>
                            <option>12</option>
                            <option selected>24</option>
                            <option>48</option>
                        </select>
                    </label>
                </div>
                <div class="controls__filters">
                    <button class="pill is-active" type="button">すべて</button>
                    <button class="pill" type="button">単体</button>
                    <button class="pill" type="button">VR</button>
                    <button class="pill" type="button">4K</button>
                    <button class="pill" type="button">最新</button>
                </div>
            </div>
        </section>

        <section class="block">
            <div class="product-grid product-grid--4" data-grid="posts"></div>
        </section>

        <nav class="pagination" aria-label="ページネーション">
            <a class="page-btn" href="#">前へ</a>
            <div class="page-numbers">
                <a class="page-btn is-current" href="#">1</a>
                <a class="page-btn" href="#">2</a>
                <a class="page-btn" href="#">3</a>
                <span class="page-ellipsis">…</span>
                <a class="page-btn" href="#">10</a>
            </div>
            <a class="page-btn" href="#">次へ</a>
        </nav>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
