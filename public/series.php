<?php
declare(strict_types=1);

$pageScripts = ['/assets/js/series.js'];

include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/nav_search.php';
?>
<div class="layout">
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="main-content">
        <section class="block">
            <div class="section-head">
                <h1 class="section-title">シリーズ一覧</h1>
                <span class="section-sub">人気シリーズをカテゴリ表示する想定</span>
            </div>
            <div class="controls">
                <div class="controls__group">
                    <label>
                        検索
                        <input type="search" placeholder="シリーズ名で検索">
                    </label>
                    <label>
                        並び替え
                        <select>
                            <option>人気</option>
                            <option>新着</option>
                            <option>名前</option>
                        </select>
                    </label>
                    <label>
                        表示件数
                        <select>
                            <option selected>24</option>
                            <option>48</option>
                        </select>
                    </label>
                </div>
            </div>
        </section>

        <section class="block">
            <div class="taxonomy-grid" data-grid="series"></div>
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
