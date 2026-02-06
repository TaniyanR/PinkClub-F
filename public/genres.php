<?php
$pageStyles = ['/assets/css/genres.css'];
$pageScripts = ['/assets/js/genres.js'];
include __DIR__ . '/partials/header.php';
?>
    <!-- partial: search -->
    <section class="search-bar">
        <div class="search-bar-inner">
            <strong class="search-note">当サイトはアフィリエイト広告を使用しています。</strong>
            <form action="#" method="get">
                <input type="text" name="s" placeholder="ジャンル名で検索">
                <button type="submit">検索</button>
            </form>
        </div>
    </section>

    <div class="layout genres-layout">
        <!-- partial: sidebar -->
        <aside class="sidebar genres-sidebar">
            <div class="sidebar-block">
                <h3>人気ジャンル（ダミー）</h3>
                <ul class="genre-mini-list">
                    <li class="genre-mini-card">
                        <a class="genre-mini-media" href="#"><span>素人</span></a>
                        <a class="genre-mini-name" href="#">素人</a>
                    </li>
                    <li class="genre-mini-card">
                        <a class="genre-mini-media" href="#"><span>人妻</span></a>
                        <a class="genre-mini-name" href="#">人妻</a>
                    </li>
                    <li class="genre-mini-card">
                        <a class="genre-mini-media" href="#"><span>巨乳</span></a>
                        <a class="genre-mini-name" href="#">巨乳</a>
                    </li>
                    <li class="genre-mini-card">
                        <a class="genre-mini-media" href="#"><span>学園</span></a>
                        <a class="genre-mini-name" href="#">学園</a>
                    </li>
                    <li class="genre-mini-card">
                        <a class="genre-mini-media" href="#"><span>OL</span></a>
                        <a class="genre-mini-name" href="#">OL</a>
                    </li>
                    <li class="genre-mini-card">
                        <a class="genre-mini-media" href="#"><span>コスプレ</span></a>
                        <a class="genre-mini-name" href="#">コスプレ</a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-block">
                <h3>広告枠</h3>
                <div class="ad-box">300x250</div>
            </div>
        </aside>

        <main class="main-content">
            <!-- partial: breadcrumb -->
            <nav class="breadcrumb block" aria-label="パンくず">
                <a href="/">Home</a>
                <span>›</span>
                <a href="#">ジャンル</a>
                <span>›</span>
                <span>一覧</span>
            </nav>

            <!-- partial: genres_title -->
            <section class="block genres-head">
                <p class="genres-subtitle">ジャンルディレクトリの一覧ページです。</p>
                <h1>ジャンル一覧</h1>
            </section>

            <!-- partial: genres_controls -->
            <section class="block genres-controls">
                <div class="genres-count">表示件数: <span data-genre-count>0件</span></div>
                <div class="genres-control-row">
                    <label>
                        ジャンル名検索
                        <input type="search" placeholder="ジャンル名を入力" data-genre-search>
                    </label>
                    <label>
                        並び替え
                        <select data-genre-sort>
                            <option value="popular">人気（想定）</option>
                            <option value="new">新着（想定）</option>
                        </select>
                    </label>
                    <label>
                        表示件数
                        <select data-genre-limit>
                            <option value="24" selected>24</option>
                            <option value="48">48</option>
                        </select>
                    </label>
                </div>
            </section>

            <!-- partial: genres_grid -->
            <section class="block">
                <div class="genres-grid" data-genres-grid></div>
            </section>

            <!-- partial: pagination -->
            <nav class="pagination block" aria-label="ページネーション">
                <a href="#" class="page-btn">前へ</a>
                <div class="page-numbers">
                    <a href="#" class="page-btn is-current">1</a>
                    <a href="#" class="page-btn">2</a>
                    <a href="#" class="page-btn">3</a>
                    <span class="page-ellipsis">…</span>
                    <a href="#" class="page-btn">8</a>
                </div>
                <a href="#" class="page-btn">次へ</a>
            </nav>
        </main>
    </div>
<?php include __DIR__ . '/partials/footer.php'; ?>
