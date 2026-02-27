<?php
require_once(__DIR__ . '/../includes/load.php');

header('Content-Type: application/json; charset=utf-8');

if (!$session->isUserLoggedIn() || !current_user()) {
  http_response_code(401);
  echo json_encode(['success' => false, 'message' => 'Unauthorized']);
  exit;
}

$action = isset($_GET['action']) ? strtolower(trim((string)$_GET['action'])) : 'load';
$layoutDir = APP_ROOT . '/storage/map';
$layoutFile = $layoutDir . '/warehouse_layout.json';

if (!is_dir($layoutDir)) {
  @mkdir($layoutDir, 0775, true);
}

if ($action === 'load') {
  if (!file_exists($layoutFile)) {
    echo json_encode(['success' => true, 'layout' => ['shelves' => []]]);
    exit;
  }

  $content = @file_get_contents($layoutFile);
  $decoded = json_decode($content, true);
  if (!is_array($decoded)) {
    echo json_encode(['success' => true, 'layout' => ['shelves' => []]]);
    exit;
  }

  echo json_encode(['success' => true, 'layout' => $decoded]);
  exit;
}

if ($action === 'save') {
  $body = file_get_contents('php://input');
  $decoded = json_decode($body, true);

  if (!is_array($decoded) || !isset($decoded['shelves']) || !is_array($decoded['shelves'])) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Invalid payload']);
    exit;
  }

  $cleanShelves = [];
  foreach ($decoded['shelves'] as $item) {
    if (!is_array($item) || empty($item['id'])) {
      continue;
    }

    $rotation = isset($item['rotation']) ? (float)$item['rotation'] : 0;
    $rotation = fmod($rotation, 360.0);
    if ($rotation < 0) {
      $rotation += 360.0;
    }

    $cleanShelves[] = [
      'id' => substr(trim((string)$item['id']), 0, 25),
      'x' => max(0, (int)($item['x'] ?? 0)),
      'y' => max(0, (int)($item['y'] ?? 0)),
      'width' => max(0.1, (float)($item['width'] ?? 1)),
      'length' => max(0.1, (float)($item['length'] ?? 1)),
      'depth' => max(0.1, (float)($item['depth'] ?? 1)),
      'levels' => max(1, (int)($item['levels'] ?? 1)),
      'capacity' => max(1, (int)($item['capacity'] ?? 1)),
      'unit' => ((string)($item['unit'] ?? 'kg') === 'lbs') ? 'lbs' : 'kg',
      'color' => substr((string)($item['color'] ?? '#1976d2'), 0, 20),
      'rotation' => $rotation
    ];
  }

  $payload = [
    'shelves' => $cleanShelves,
    'pxPerMeter' => isset($decoded['pxPerMeter']) ? (float)$decoded['pxPerMeter'] : 40,
    'updatedAt' => date('c')
  ];

  $ok = @file_put_contents($layoutFile, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

  if ($ok === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to persist layout']);
    exit;
  }

  echo json_encode(['success' => true, 'saved' => count($cleanShelves)]);
  exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Unsupported action']);
