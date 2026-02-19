<?php
function json_ok($data = null): string {
    return json_encode([
        'ok' => true,
        'data' => $data,
    ]);
}

function json_error(string $code, string $message, $details = null): string {
    $error = [
        'code' => $code,
        'message' => $message,
    ];
    if ($details !== null) {
        $error['details'] = $details;
    }
    return json_encode([
        'ok' => false,
        'error' => $error,
    ]);
}

function send_json(string $payload, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo $payload;
}
