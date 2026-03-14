<?php
/**
 * CORS Proxy for VICIdial Non-Agent API
 * Routes browser requests through the server to avoid CORS restrictions.
 * Usage: proxy.php?url=<fully-encoded-target-url>
 */

// Allow requests from any origin (this proxy is the local intermediary)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Get the target URL
$url = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url)) {
    http_response_code(400);
    echo 'ERROR: No URL provided. Usage: proxy.php?url=<encoded-url>';
    exit;
}

// Validate URL starts with http:// or https://
if (!preg_match('/^https?:\/\//i', $url)) {
    http_response_code(400);
    echo 'ERROR: Invalid URL. Must start with http:// or https://';
    exit;
}

// Make the request via cURL
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_USERAGENT      => 'VICIdial-API-Panel/1.0',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error    = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(502);
    echo 'ERROR: Proxy request failed - ' . $error;
    exit;
}

// Forward the HTTP status code
http_response_code($httpCode);
header('Content-Type: text/plain; charset=utf-8');
echo $response;
