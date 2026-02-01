<?php
declare(strict_types=1);

require_once __DIR__ . '/../../lib/config.php';

function array_get_path(array $data, string $path, mixed $default = null): mixed
{
    $segments = explode('.', $path);
    $value = $data;
    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }
    return $value;
}

function array_set_path(array &$data, string $path, mixed $value): void
{
    $segments = explode('.', $path);
    $current =& $data;
    foreach ($segments as $segment) {
        if (!isset($current[$segment]) || !is_array($current[$segment])) {
            $current[$segment] = [];
        }
        $current =& $current[$segment];
    }
    $current = $value;
}

function array_unset_path(array &$data, string $path): void
{
    $segments = explode('.', $path);
    $parents = [];
    $current =& $data;

    foreach ($segments as $segment) {
        if (!isset($current[$segment])) {
            return;
        }
        $parents[] = [&$current, $segment];
        $current =& $current[$segment];
    }

    $lastInfo = array_pop($parents);
    if ($lastInfo) {
        $parent =& $lastInfo[0];
        $last = $lastInfo[1];
        unset($parent[$last]);
    }

    while ($parents) {
        $info = array_pop($parents);
        $parent =& $info[0];
        $key = $info[1];
        if (isset($parent[$key]) && is_array($parent[$key]) && $parent[$key] === []) {
            unset($parent[$key]);
        }
    }
}

function set_local_override(array &$local, array $base, string $path, mixed $value, bool $skipIfEmpty = false): void
{
    if ($skipIfEmpty && $value === '') {
        return;
    }

    $baseValue = array_get_path($base, $path);
    if ($value === $baseValue) {
        array_unset_path($local, $path);
        return;
    }

    array_set_path($local, $path, $value);
}

$errors = [];
$saved = false;
$baseConfig = config_base();
$localConfig = config_local();
$currentConfig = config();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteTitle = trim($_POST['site_title'] ?? '');
    $siteBaseUrl = trim($_POST['site_base_url'] ?? '');
    $dbDsn = trim($_POST['db_dsn'] ?? '');
    $dbUser = trim($_POST['db_user'] ?? '');
    $dbPassword = trim($_POST['db_password'] ?? '');

    $apiId = trim($_POST['dmm_api_id'] ?? '');
    $affiliateId = trim($_POST['dmm_affiliate_id'] ?? '');
    $apiSite = trim($_POST['dmm_site'] ?? '');
    $apiService = trim($_POST['dmm_service'] ?? '');
    $apiFloor = trim($_POST['dmm_floor'] ?? '');
    $apiHits = (int)($_POST['dmm_hits'] ?? 0);
    $apiSort = trim($_POST['dmm_sort'] ?? '');
    $apiOutput = trim($_POST['dmm_output'] ?? '');

    if ($apiHits < 1) {
        $apiHits = 1;
    }

    set_local_override($localConfig, $baseConfig, 'site.title', $siteTitle);
    set_local_override($localConfig, $baseConfig, 'site.base_url', $siteBaseUrl);
    set_local_override($localConfig, $baseConfig, 'db.dsn', $dbDsn);
    set_local_override($localConfig, $baseConfig, 'db.user', $dbUser);
    set_local_override($localConfig, $baseConfig, 'db.password', $dbPassword, true);

    set_local_override($localConfig, $baseConfig, 'dmm_api.api_id', $apiId);
    set_local_override($localConfig, $baseConfig, 'dmm_api.affiliate_id', $affiliateId);
    set_local_override($localConfig, $baseConfig, 'dmm_api.site', $apiSite);
    set_local_override($localConfig, $baseConfig, 'dmm_api.service', $apiService);
    set_local_override($localConfig, $baseConfig, 'dmm_api.floor', $apiFloor);
    set_local_override($localConfig, $baseConfig, 'dmm_api.hits', $apiHits);
    set_local_override($localConfig, $baseConfig, 'dmm_api.sort', $apiSort);
    set_local_override($localConfig, $baseConfig, 'dmm_api.output', $apiOutput);

    $export = "<?php\nreturn " . var_export($localConfig, true) . ";\n";
    $path = __DIR__ . '/../../config.local.php';
    if (file_put_contents($path, $export) === false) {
        $errors[] = '設定の保存に失敗しました。ファイルの書き込み権限を確認してください。';
    } else {
        $saved = true;
        $currentConfig = array_replace_recursive($baseConfig, $localConfig);
    }
}

include __DIR__ . '/../partials/header.php';
?>
<main>
    <h1>API設定</h1>
    <form class="admin-card" method="post" action="/admin/settings.php">
        <label>Site Title</label>
        <input type="text" name="site_title" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'site.title', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Base URL</label>
        <input type="text" name="site_base_url" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'site.base_url', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>DB DSN</label>
        <input type="text" name="db_dsn" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'db.dsn', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>DB User</label>
        <input type="text" name="db_user" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'db.user', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>DB Password</label>
        <input type="text" name="db_password" value="">

        <label>API ID</label>
        <input type="text" name="dmm_api_id" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.api_id', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Affiliate ID</label>
        <input type="text" name="dmm_affiliate_id" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.affiliate_id', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Site</label>
        <input type="text" name="dmm_site" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.site', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Service</label>
        <input type="text" name="dmm_service" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.service', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Floor</label>
        <input type="text" name="dmm_floor" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.floor', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Hits</label>
        <input type="number" name="dmm_hits" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.hits', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Sort</label>
        <input type="text" name="dmm_sort" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.sort', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label>Output</label>
        <input type="text" name="dmm_output" value="<?php echo htmlspecialchars((string)array_get_path($currentConfig, 'dmm_api.output', ''), ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">保存</button>
    </form>

    <?php if ($saved) : ?>
        <div class="admin-card">
            <p>設定を保存しました。</p>
        </div>
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
</main>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
