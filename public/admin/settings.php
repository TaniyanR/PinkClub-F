<?php
declare(strict_types=1);

require_once __DIR__ . '/../../lib/config.php';

$errors = [];
$saved = false;
$localPath = __DIR__ . '/../../config.local.php';
$localConfig = is_file($localPath) ? require $localPath : [];
if (!is_array($localConfig)) {
    $localConfig = [];
}

function config_set(array $base, string $path, $value): array
{
    $segments = array_filter(explode('.', $path), 'strlen');
    if (!$segments) {
        return $base;
    }

    $data = $base;
    $ref = &$data;
    foreach ($segments as $segment) {
        if (!isset($ref[$segment]) || !is_array($ref[$segment])) {
            $ref[$segment] = [];
        }
        $ref = &$ref[$segment];
    }
    $ref = $value;
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteTitle = trim((string)($_POST['site_title'] ?? ''));
    $siteBaseUrl = trim((string)($_POST['site_base_url'] ?? ''));
    $dbDsn = trim((string)($_POST['db_dsn'] ?? ''));
    $dbUser = trim((string)($_POST['db_user'] ?? ''));
    $dbPassword = trim((string)($_POST['db_password'] ?? ''));

    $apiId = trim((string)($_POST['api_id'] ?? ''));
    $affiliateId = trim((string)($_POST['affiliate_id'] ?? ''));
    $apiSite = trim((string)($_POST['api_site'] ?? 'FANZA'));
    $apiService = trim((string)($_POST['api_service'] ?? 'digital'));
    $apiFloor = trim((string)($_POST['api_floor'] ?? 'videoa'));
    $apiHits = (int)($_POST['api_hits'] ?? 20);
    $apiSort = trim((string)($_POST['api_sort'] ?? 'date'));
    $apiOutput = trim((string)($_POST['api_output'] ?? 'json'));

    if ($siteTitle === '') {
        $errors[] = 'サイトタイトルは必須です。';
    }
    if ($dbDsn === '') {
        $errors[] = 'DB DSNは必須です。';
    }
    if ($dbUser === '') {
        $errors[] = 'DBユーザーは必須です。';
    }
    if ($apiHits <= 0) {
        $apiHits = 20;
    }

    if (!$errors) {
        $override = $localConfig;
        $override = config_set($override, 'site.title', $siteTitle);
        $override = config_set($override, 'site.base_url', $siteBaseUrl);
        $override = config_set($override, 'db.dsn', $dbDsn);
        $override = config_set($override, 'db.user', $dbUser);
        if ($dbPassword !== '') {
            $override = config_set($override, 'db.password', $dbPassword);
        }
        $override = config_set($override, 'dmm_api.api_id', $apiId);
        $override = config_set($override, 'dmm_api.affiliate_id', $affiliateId);
        $override = config_set($override, 'dmm_api.site', $apiSite !== '' ? $apiSite : 'FANZA');
        $override = config_set($override, 'dmm_api.service', $apiService !== '' ? $apiService : 'digital');
        $override = config_set($override, 'dmm_api.floor', $apiFloor !== '' ? $apiFloor : 'videoa');
        $override = config_set($override, 'dmm_api.hits', $apiHits);
        $override = config_set($override, 'dmm_api.sort', $apiSort !== '' ? $apiSort : 'date');
        $override = config_set($override, 'dmm_api.output', $apiOutput !== '' ? $apiOutput : 'json');

        $export = "<?php\ndeclare(strict_types=1);\n\nreturn " . var_export($override, true) . ";\n";
        $result = @file_put_contents($localPath, $export);
        if ($result === false) {
            $error = error_get_last();
            $errors[] = '保存に失敗しました。' . ($error['message'] ?? '');
        } else {
            $saved = true;
            config_reset();
            config();
        }
    }
}

include __DIR__ . '/../partials/header.php';
?>
<main>
    <h1>設定</h1>
    <?php if ($saved) : ?>
        <div class="admin-card">保存しました。</div>
    <?php endif; ?>
    <?php if ($errors) : ?>
        <div class="admin-card">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form class="admin-card" method="post" action="/admin/settings.php">
        <h2>サイト設定</h2>
        <label>Site Title</label>
        <input type="text" name="site_title" value="<?php echo htmlspecialchars((string)config_get('site.title', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Base URL</label>
        <input type="text" name="site_base_url" value="<?php echo htmlspecialchars((string)config_get('site.base_url', ''), ENT_QUOTES, 'UTF-8'); ?>">

        <h2>DB設定</h2>
        <label>DSN</label>
        <input type="text" name="db_dsn" value="<?php echo htmlspecialchars((string)config_get('db.dsn', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>User</label>
        <input type="text" name="db_user" value="<?php echo htmlspecialchars((string)config_get('db.user', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Password (空なら維持)</label>
        <input type="password" name="db_password" value="">

        <h2>DMM API設定</h2>
        <label>API ID</label>
        <input type="text" name="api_id" value="<?php echo htmlspecialchars((string)config_get('dmm_api.api_id', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Affiliate ID</label>
        <input type="text" name="affiliate_id" value="<?php echo htmlspecialchars((string)config_get('dmm_api.affiliate_id', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Site</label>
        <input type="text" name="api_site" value="<?php echo htmlspecialchars((string)config_get('dmm_api.site', 'FANZA'), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Service</label>
        <input type="text" name="api_service" value="<?php echo htmlspecialchars((string)config_get('dmm_api.service', 'digital'), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Floor</label>
        <input type="text" name="api_floor" value="<?php echo htmlspecialchars((string)config_get('dmm_api.floor', 'videoa'), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Hits</label>
        <input type="number" name="api_hits" value="<?php echo htmlspecialchars((string)config_get('dmm_api.hits', 20), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Sort</label>
        <input type="text" name="api_sort" value="<?php echo htmlspecialchars((string)config_get('dmm_api.sort', 'date'), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Output</label>
        <input type="text" name="api_output" value="<?php echo htmlspecialchars((string)config_get('dmm_api.output', 'json'), ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">保存</button>
    </form>
</main>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
