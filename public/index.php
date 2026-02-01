<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/repository.php';

$new3 = fetch_items('date_published DESC', 3);
$new10 = fetch_items('date_published DESC', 10);
$pickup10 = fetch_items('RAND()', 10);

include __DIR__ . '/partials/header.php';
?>
<main>

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
