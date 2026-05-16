<?php

$baseUrl = rtrim(getenv('OPENROUTER_BASE_URL') ?: 'https://openrouter.ai/api/v1', '/');
$apiKey = getenv('OPENROUTER_API_KEY') ?: '';
$model = getenv('OPENROUTER_MODEL') ?: '';
$verifyTls = getenv('OPENROUTER_VERIFY_TLS');
$verifyTls = $verifyTls === false ? '(env not set)' : $verifyTls;

$endpoint = $baseUrl . '/models';

echo "OpenRouter diagnose\n";
echo "- base_url: {$baseUrl}\n";
echo "- endpoint: {$endpoint}\n";
echo "- model: {$model}\n";
echo "- verify_tls env: {$verifyTls}\n";
echo "- api_key prefix: " . ($apiKey ? substr($apiKey, 0, 12) . '...' : '(empty)') . "\n\n";

if (!function_exists('curl_init')) {
    fwrite(STDERR, "ERROR: PHP curl extension not available\n");
    exit(3);
}

$ch = curl_init($endpoint);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiKey,
        'Accept: application/json',
    ],
]);

$out = curl_exec($ch);

if ($out === false) {
    $errno = curl_errno($ch);
    $err = curl_error($ch);
    fwrite(STDERR, "CURL_ERRNO: {$errno}\n");
    fwrite(STDERR, "CURL_ERROR: {$err}\n");
    exit(2);
}

$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP {$httpCode}\n";

$snippet = substr($out, 0, 500);
echo "Body snippet (first 500 chars):\n";
echo $snippet . "\n";

exit(0);
