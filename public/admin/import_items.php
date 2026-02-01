<?php
require_once __DIR__ . '/../../lib/config.php';
require_once __DIR__ . '/../../lib/db.php';
require_once __DIR__ . '/../../lib/dmm_api.php';
require_once __DIR__ . '/../../lib/repository.php';

$config = config();
$apiConfig = $config['dmm_api'] ?? ($config['api'] ?? []);

$resultLog = [];
$errorLog = [];

function api_base_params(array $apiConfig): array
{
    return [
        'api_id' => $apiConfig['api_id'] ?? '',
        'affiliate_id' => $apiConfig['affiliate_id'] ?? '',
        'site' => $apiConfig['site'] ?? 'FANZA',
        'service' => $apiConfig['service'] ?? 'digital',
        'floor' => $apiConfig['floor'] ?? 'videoa',
    ];
}

function normalize_iteminfo_list($value): array
{
    if (!is_array($value)) {
        return [];
    }

    $keys = array_keys($value);
    $isList = $keys === array_keys($keys);
    if (!$isList) {
        return [$value];
    }

    return $value;
}

function normalize_actress_payload(array $actress): array
{
    $listUrl = $actress['list_url'] ?? $actress['listurl'] ?? [];
    return [
        'id' => (int)($actress['id'] ?? 0),
        'name' => $actress['name'] ?? '',
        'ruby' => $actress['ruby'] ?? null,
        'bust' => null,
        'cup' => null,
        'waist' => null,
        'hip' => null,
        'height' => null,
        'birthday' => null,
        'blood_type' => null,
        'hobby' => null,
        'prefectures' => null,
        'image_small' => $actress['imageURL']['small'] ?? ($actress['image_small'] ?? null),
        'image_large' => $actress['imageURL']['large'] ?? ($actress['image_large'] ?? null),
        'listurl_digital' => is_array($listUrl) ? ($listUrl['digital'] ?? null) : null,
        'listurl_monthly' => is_array($listUrl) ? ($listUrl['monthly'] ?? null) : null,
        'listurl_mono' => is_array($listUrl) ? ($listUrl['mono'] ?? null) : null,
    ];
}

function normalize_taxonomy_payload(array $taxonomy): array
{
    return [
        'id' => (int)($taxonomy['id'] ?? 0),
        'name' => $taxonomy['name'] ?? '',
        'ruby' => $taxonomy['ruby'] ?? null,
        'list_url' => $taxonomy['list_url'] ?? ($taxonomy['listurl'] ?? null),
        'site_code' => $taxonomy['site_code'] ?? null,
        'service_code' => $taxonomy['service_code'] ?? null,
        'floor_id' => $taxonomy['floor_id'] ?? null,
        'floor_code' => $taxonomy['floor_code'] ?? null,
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hits = min(100, max(1, (int)($_POST['hits'] ?? 100)));
    $startOffset = max(1, (int)($_POST['offset'] ?? 1));
    $maxPages = max(1, (int)($_POST['pages'] ?? 1));
    $keyword = trim($_POST['keyword'] ?? '');

    $paramsBase = api_base_params($apiConfig);

    $inserted = 0;
    $updated = 0;

    for ($page = 0; $page < $maxPages; $page++) {
        $offset = $startOffset + ($page * $hits);
        $params = array_merge($paramsBase, [
            'hits' => $hits,
            'offset' => $offset,
        ]);

        if ($keyword !== '') {
            $params['keyword'] = $keyword;
        }

        $response = dmm_api_request('ItemList', $params);
        if (!$response['ok']) {
            $errorLog[] = sprintf('APIエラー: HTTP %d %s', $response['http_code'], $response['error']);
            break;
        }

        $data = $response['data']['result'] ?? [];
        if (($data['status'] ?? '') !== '200') {
            $errorLog[] = sprintf('APIステータスエラー: %s', $data['status'] ?? 'unknown');
            break;
        }

        $list = $data['items'] ?? [];
        foreach ($list as $row) {
            $contentId = $row['content_id'] ?? '';
            if ($contentId === '') {
                continue;
            }

            $pdo = db();
            $pdo->beginTransaction();
            try {
                $price = $row['prices']['price'] ?? ($row['price'] ?? null);
                $result = upsert_item([
                    'content_id' => $contentId,
                    'product_id' => $row['product_id'] ?? '',
                    'title' => $row['title'] ?? '',
                    'url' => $row['URL'] ?? '',
                    'affiliate_url' => $row['affiliateURL'] ?? '',
                    'image_list' => $row['imageURL']['list'] ?? '',
                    'image_small' => $row['imageURL']['small'] ?? '',
                    'image_large' => $row['imageURL']['large'] ?? '',
                    'date_published' => $row['date'] ?? null,
                    'service_code' => $row['service_code'] ?? '',
                    'floor_code' => $row['floor_code'] ?? '',
                    'category_name' => $row['category_name'] ?? '',
                    'price_min' => is_numeric($price) ? (int)$price : null,
                ]);

                $itemInfo = $row['iteminfo'] ?? [];
                $actressIds = [];
                foreach (normalize_iteminfo_list($itemInfo['actress'] ?? []) as $actress) {
                    $payload = normalize_actress_payload($actress);
                    if ($payload['id'] > 0 && $payload['name'] !== '') {
                        upsert_actress($payload);
                        $actressIds[] = $payload['id'];
                    }
                }

                $genreIds = [];
                foreach (normalize_iteminfo_list($itemInfo['genre'] ?? []) as $genre) {
                    $payload = normalize_taxonomy_payload($genre);
                    if ($payload['id'] > 0 && $payload['name'] !== '') {
                        upsert_taxonomy('genres', 'id', $payload);
                        $genreIds[] = $payload['id'];
                    }
                }

                $makerIds = [];
                foreach (normalize_iteminfo_list($itemInfo['maker'] ?? []) as $maker) {
                    $payload = normalize_taxonomy_payload($maker);
                    if ($payload['id'] > 0 && $payload['name'] !== '') {
                        upsert_taxonomy('makers', 'id', $payload);
                        $makerIds[] = $payload['id'];
                    }
                }

                $seriesIds = [];
                foreach (normalize_iteminfo_list($itemInfo['series'] ?? []) as $series) {
                    $payload = normalize_taxonomy_payload($series);
                    if ($payload['id'] > 0 && $payload['name'] !== '') {
                        upsert_taxonomy('series', 'id', $payload);
                        $seriesIds[] = $payload['id'];
                    }
                }

                $labels = [];
                foreach (normalize_iteminfo_list($itemInfo['label'] ?? []) as $label) {
                    $labelName = $label['name'] ?? '';
                    if ($labelName === '') {
                        continue;
                    }
                    $labels[] = [
                        'id' => isset($label['id']) ? (int)$label['id'] : null,
                        'name' => $labelName,
                        'ruby' => $label['ruby'] ?? null,
                    ];
                }

                replace_item_relations($contentId, $actressIds, 'item_actresses', 'actress_id');
                replace_item_relations($contentId, $genreIds, 'item_genres', 'genre_id');
                replace_item_relations($contentId, $makerIds, 'item_makers', 'maker_id');
                replace_item_relations($contentId, $seriesIds, 'item_series', 'series_id');
                replace_item_labels($contentId, $labels);

                $pdo->commit();
                $result['status'] === 'inserted' ? $inserted++ : $updated++;
            } catch (Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                log_message('import_items failed: ' . $contentId . ' ' . $e->getMessage());
                $errorLog[] = sprintf('content_id %s の処理に失敗しました。', $contentId);
            }
        }

        $resultLog[] = sprintf('offset %d を処理しました。', $offset);
    }

    $resultLog[] = sprintf('追加 %d件 / 更新 %d件', $inserted, $updated);
}

include __DIR__ . '/../partials/header.php';
?>
<main>
    <h1>作品インポート</h1>
    <div class="admin-card">
        <form method="post">
            <label>Hits (最大100)</label>
            <input type="number" name="hits" value="100">
            <label>Offset (開始)</label>
            <input type="number" name="offset" value="1">
            <label>ページ数</label>
            <input type="number" name="pages" value="1">
            <label>キーワード (任意)</label>
            <input type="text" name="keyword" value="">
            <button type="submit">インポート</button>
        </form>
    </div>

    <?php if ($resultLog) : ?>
        <div class="admin-card">
            <h2>結果</h2>
            <ul>
                <?php foreach ($resultLog as $line) : ?>
                    <li><?php echo htmlspecialchars($line, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($errorLog) : ?>
        <div class="admin-card">
            <h2>エラー</h2>
            <ul>
                <?php foreach ($errorLog as $line) : ?>
                    <li><?php echo htmlspecialchars($line, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
