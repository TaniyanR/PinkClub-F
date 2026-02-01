<?php
require_once __DIR__ . '/../../lib/config.php';
$config = config();
$apiConfig = $config['dmm_api'] ?? ($config['api'] ?? []);
include __DIR__ . '/../partials/header.php';
?>
<main>
    <h1>API設定</h1>
    <form class="admin-card" method="post" action="/admin/save_settings.php">
        <label>API ID</label>
        <input type="text" name="api_id" value="<?php echo htmlspecialchars($apiConfig['api_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <label>Affiliate ID</label>
        <input type="text" name="affiliate_id" value="<?php echo htmlspecialchars($apiConfig['affiliate_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <label>Site</label>
        <input type="text" name="site" value="<?php echo htmlspecialchars($apiConfig['site'] ?? 'FANZA', ENT_QUOTES, 'UTF-8'); ?>">
        <label>Service</label>
        <input type="text" name="service" value="<?php echo htmlspecialchars($apiConfig['service'] ?? 'digital', ENT_QUOTES, 'UTF-8'); ?>">
        <label>Floor</label>
        <input type="text" name="floor" value="<?php echo htmlspecialchars($apiConfig['floor'] ?? 'videoa', ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">保存</button>
    </form>
</main>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
