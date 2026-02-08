<?php
declare(strict_types=1);

require_once __DIR__ . '/_bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$apiConfig = config_get('dmm_api', []);
$connectTimeout = 10;
$timeout = 20;
$allowedSites = ['FANZA', 'DMM'];
$allowedServices = ['digital'];
$allowedFloors = ['videoa'];
$currentSite = 'FANZA';
$currentService = 'digital';
$currentFloor = 'videoa';

if (is_array($apiConfig)) {
    $siteValue = (string)($apiConfig['site'] ?? '');
    if (in_array($siteValue, $allowedSites, true)) {
        $currentSite = $siteValue;
    }

    $serviceValue = (string)($apiConfig['service'] ?? '');
    if (in_array($serviceValue, $allowedServices, true)) {
        $currentService = $serviceValue;
    }

    $floorValue = (string)($apiConfig['floor'] ?? '');
    if (in_array($floorValue, $allowedFloors, true)) {
        $currentFloor = $floorValue;
    }

    $connectTimeoutValue = filter_var($apiConfig['connect_timeout'] ?? null, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 30],
    ]);
    if ($connectTimeoutValue !== false) {
        $connectTimeout = $connectTimeoutValue;
    }

    $timeoutValue = filter_var($apiConfig['timeout'] ?? null, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 5, 'max_range' => 60],
    ]);
    if ($timeoutValue !== false) {
        $timeout = $timeoutValue;
    }
}

$localPath = __DIR__ . '/../../config.local.php';

$errorMessages = [
    'missing_required'  => 'API ID / アフィリエイトIDが未入力です。対象ファイル: ' . $localPath,
    'csrf_failed'       => '不正なリクエストです。対象ファイル: ' . $localPath,
    'not_writable_dir'  => '設定ディレクトリに書き込めません。対象ファイル: ' . $localPath . '（ディレクトリ権限を確認してください）',
    'not_writable_file' => '設定ファイルに書き込めません。対象ファイル: ' . $localPath . '（ファイル権限を確認してください）',
    'write_failed'      => 'config.local.php に書き込めません。対象ファイル: ' . $localPath . '（権限を確認してください）',
    'rename_failed'     => '設定ファイルの更新に失敗しました。対象ファイル: ' . $localPath . '（ディスク/権限を確認してください）',
];

include __DIR__ . '/../partials/header.php';
?>
<main>
    <h1>API設定</h1>
    <p class="admin-form-note">APIが一時的に失敗した場合、最大60分以内のキャッシュを表示します（空になりにくい）</p>

    <?php if (($_GET['saved'] ?? '') === '1') : ?>
        <div class="admin-card">
            <p>保存しました。</p>
        </div>
    <?php endif; ?>

    <?php if (($_GET['error'] ?? '') !== '') : ?>
        <div class="admin-card">
            <?php
            $errorCode = (string)($_GET['error'] ?? '');
            $errorMessage = $errorMessages[$errorCode] ?? ('エラーが発生しました。対象ファイル: ' . $localPath . '（' . $errorCode . '）');
            ?>
            <p><?php echo e($errorMessage); ?></p>
        </div>
    <?php endif; ?>

    <form class="admin-card" method="post" action="/admin/save_settings.php">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

        <label>API ID</label>
        <input type="text" name="api_id" value="<?php echo e((string)($apiConfig['api_id'] ?? '')); ?>">

        <label>Affiliate ID</label>
        <input type="text" name="affiliate_id" value="<?php echo e((string)($apiConfig['affiliate_id'] ?? '')); ?>">

        <label>Site</label>
        <select name="site">
            <?php foreach ($allowedSites as $siteOption) : ?>
                <option value="<?php echo e($siteOption); ?>"<?php echo $siteOption === $currentSite ? ' selected' : ''; ?>>
                    <?php echo e($siteOption); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Service</label>
        <select name="service">
            <?php foreach ($allowedServices as $serviceOption) : ?>
                <option value="<?php echo e($serviceOption); ?>"<?php echo $serviceOption === $currentService ? ' selected' : ''; ?>>
                    <?php echo e($serviceOption); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Floor</label>
        <select name="floor">
            <?php foreach ($allowedFloors as $floorOption) : ?>
                <option value="<?php echo e($floorOption); ?>"<?php echo $floorOption === $currentFloor ? ' selected' : ''; ?>>
                    <?php echo e($floorOption); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>接続タイムアウト秒</label>
        <input type="number" name="connect_timeout" min="1" max="30" step="1" value="<?php echo e((string)$connectTimeout); ?>">
        <p class="admin-form-note">接続開始から確立までの最大秒数</p>

        <label>全体タイムアウト秒</label>
        <input type="number" name="timeout" min="5" max="60" step="1" value="<?php echo e((string)$timeout); ?>">
        <p class="admin-form-note">接続後、レスポンス完了までの最大秒数</p>

        <button type="submit">保存</button>
    </form>
</main>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
