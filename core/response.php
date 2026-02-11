<?php

function json_ok($data = null, $http_code = 200)
{
  if (!headers_sent()) {
    http_response_code($http_code);
    header('Content-Type: application/json; charset=utf-8');
  }
  echo json_encode([
    'ok' => true,
    'data' => $data
  ]);
  exit;
}

function json_error($code, $message, $details = null, $http_code = 400)
{
  if (!headers_sent()) {
    http_response_code($http_code);
    header('Content-Type: application/json; charset=utf-8');
  }
  $error = [
    'code' => $code,
    'message' => $message
  ];
  if ($details !== null) {
    $error['details'] = $details;
  }
  echo json_encode([
    'ok' => false,
    'error' => $error
  ]);
  exit;
}

?>
