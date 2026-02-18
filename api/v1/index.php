<?php

require_once(__DIR__ . '/../../core/bootstrap.php');
require_once(__DIR__ . '/controllers/ProjectController.php');
require_once(__DIR__ . '/controllers/ProductController.php');
require_once(__DIR__ . '/controllers/IntegrationProjectController.php');

$resource = $_GET['resource'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

// Support method override via POST _method
if ($method === 'POST' && !empty($_POST['_method'])) {
  $method = strtoupper($_POST['_method']);
}

// Parse body for PUT/PATCH/DELETE and optional JSON payloads
$input = [];
$rawBody = file_get_contents('php://input');

if (in_array($method, ['PUT', 'PATCH', 'DELETE'], true)) {
  parse_str($rawBody, $input);
}

$jsonBody = json_decode($rawBody, true);
if (is_array($jsonBody)) {
  $input = array_merge($input, $jsonBody);
  if ($method === 'POST') {
    $_POST = array_merge($_POST, $jsonBody);
  }
}

switch ($resource) {
  case 'projects':
    if ($method === 'GET') {
      ProjectController::index();
    }
    if ($method === 'POST') {
      ProjectController::create($_POST);
    }
    if (in_array($method, ['PUT', 'PATCH'], true)) {
      $id = $_GET['id'] ?? ($input['id'] ?? null);
      ProjectController::update($id, $input);
    }
    if ($method === 'DELETE') {
      $id = $_GET['id'] ?? ($input['id'] ?? null);
      ProjectController::delete($id);
    }
    json_error('method_not_allowed', 'Method not allowed.', null, 405);
    break;

  case 'products':
    if ($method === 'GET') {
      ProductController::find($_GET);
    }
    json_error('method_not_allowed', 'Method not allowed.', null, 405);
    break;

  case 'integration.projects.upsert':
    if ($method === 'POST') {
      IntegrationProjectController::upsert($_POST);
    }
    json_error('method_not_allowed', 'Method not allowed.', null, 405);
    break;

  case 'integration.projects.snapshot':
    if ($method === 'GET') {
      IntegrationProjectController::snapshot($_GET);
    }
    json_error('method_not_allowed', 'Method not allowed.', null, 405);
    break;

  default:
    json_error('not_found', 'Resource not found.', null, 404);
}

?>

