<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

function dmm_api_request(string $endpoint, array $params): array
{
    // configのdmm_apiをベースに不足があれば補う（params側が優先）
    $api = config_get('dmm_api', []);
    if (is_array($api)) {
        $base = [
            'api_id' => (string)($api['api_id'] ?? ''),
            'affiliate_id' => (string)($api['affiliate_id'] ?? ''),
            'site' => (string)($api['site'] ?? ''),
            'service' => (string)($api['service'] ?? ''),
            'floor' => (string)($api['floor'] ?? ''),
        ];
        foreach ($base as $k => $v) {
            if (!array_key_exists($k, $params) || $params[$k] === '' || $params[$k] === null) {
                // site/service/floor も空なら補完（空のままだとAPI側で落ちる）
                $params[$k] = $v;
            }
        }
    }

    // 最低限必須（空ならAPIを叩かない）
    $required = ['api_id', 'affiliate_id', 'site', 'service', 'floor'];
    foreach ($required as $k) {
        if (empty($params[$k])) {
            return [
                'ok' => false,
                'http_code' => 0,
                'error' => 'Missing required param: ' . $k,
                'raw' => null,
                'data' => null,
            ];
        }
    }

    $endpoint = trim($endpoint);
    if ($endpoint === '') {
        return [
            'ok' => false,
            'http_code' => 0,
            'error' => 'Missing endpoint',
            'raw' => null,
            'data' => null,
        ];
    }

    $url = 'https://api.dmm.com/affiliate/v3/' . rawurlencode($endpoint);
    $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    $fullUrl = $url . '?' . $query;

    $ch = curl_init($fullUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 20,          // 応答全体
        CURLOPT_CONNECTTIMEOUT => 10,   // 接続
        CURLOPT_FAILONERROR => false,   // HTTPエラーでも本文を拾う
        CURLOPT_USERAGENT => 'PinkClub-F/1.0 (+https://example.invalid)',
    ]);

    $raw = curl_exec($ch);
    $curlErrNo = curl_errno($ch);
    $curlErr = curl_error($ch);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) {
        if (function_exists('log_message')) {
            log_message('API request failed: errno=' . $curlErrNo . ' error=' . $curlErr);
        }
        return [
            'ok' => false,
            'http_code' => $httpCode,
            'error' => $curlErr !== '' ? $curlErr : ('cURL error ' . $curlErrNo),
            'raw' => null,
            'data' => null,
        ];
    }

    // HTTP非2xxはok=false（本文はrawに残す）
    if ($httpCode < 200 || $httpCode >= 300) {
        if (function_exists('log_message')) {
            log_message('API http error: ' . $httpCode . ' endpoint=' . $endpoint);
        }
        return [
            'ok' => false,
            'http_code' => $httpCode,
            'error' => 'HTTP ' . $httpCode,
            'raw' => $raw,
            'data' => null,
        ];
    }

    $data = json_decode($raw, true);
    if (!is_array($data)) {
        if (function_exists('log_message')) {
            log_message('API response JSON decode failed: ' . substr($raw, 0, 500));
        }
        return [
            'ok' => false,
            'http_code' => $httpCode,
            'error' => 'Invalid JSON',
            'raw' => $raw,
            'data' => null,
        ];
    }

    return [
        'ok' => true,
        'http_code' => $httpCode,
        'error' => null,
        'raw' => $raw,
        'data' => $data,
    ];
}
