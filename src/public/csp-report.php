<?php
// Get the raw POST data
$input = file_get_contents('php://input');

if (empty($input)) {
    http_response_code(400);
    exit;
}

$report = json_decode($input, true);

// Check for JSON decoding errors
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    exit;
}

// Validate the structure of the report to match expected CSP report format
if (!is_array($report) ||
    !array_key_exists('csp-report', $report) ||
    !is_array($report['csp-report']) ||
    !array_key_exists('document-uri', $report['csp-report']) ||
    !array_key_exists('violated-directive', $report['csp-report'])) {
    http_response_code(400);
    exit;
}

$timestamp = date('Y-m-d H:i:s');
$proxyServer = '';

if ($_SERVER['PROXY_SERVER']){
    $proxyServer = $_SERVER['PROXY_SERVER'];
}

$report['timestamp'] = $timestamp;
$report['PROXY_SERVER'] = $proxyServer;
$logEntry = json_encode($report);

// Log to a file (make sure the directory is writable by your web server)
if (file_put_contents(__DIR__ . '/../logs/csp_violations.log', $logEntry . PHP_EOL, FILE_APPEND | LOCK_EX) === false) {
    error_log('Failed to write CSP violation report');
    http_response_code(500);
    exit;
}
// Respond with 204 No Content
http_response_code(204);
?>
