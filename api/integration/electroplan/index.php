<?php

require_once(__DIR__ . '/../../../core/bootstrap.php');
require_once(__DIR__ . '/../../v1/controllers/IntegrationProjectController.php');

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$base = '/api/integration/electroplan';

$path = $uri;
$pos = strpos($uri, $base);
if ($pos !== false) {
  $path = substr($uri, $pos + strlen($base));
}
$path = trim($path, '/');

$raw = file_get_contents('php://input');
$json = json_decode($raw, true);
$body = is_array($json) ? $json : $_POST;

if ($method === 'POST' && $path === 'projects/upsert') {
  IntegrationProjectController::upsert($body);
}

if ($method === 'GET') {
  if (preg_match('#^projects/([^/]+)$#', $path, $m)) {
    $_GET['project_id'] = urldecode($m[1]);
    IntegrationProjectController::snapshot($_GET);
  }

  if ($path === 'projects' && !empty($_GET['project_id'])) {
    IntegrationProjectController::snapshot($_GET);
  }
}

json_error('not_found', 'Route not found.', null, 404);

?>