<?php

class IntegrationProjectService
{
  public static function hasIntegrationSchema()
  {
    return self::columnExists('projects', 'project_id')
      && self::columnExists('projects', 'status')
      && self::columnExists('projects', 'external_updated_at')
      && self::columnExists('projects', 'metadata_json')
      && self::columnExists('projects', 'last_synced_at');
  }

  public static function upsertByExternalProjectId($projectId, $name, $status = null, $updatedAt = null, $metadataJson = null)
  {
    global $db;

    $projectIdEsc = $db->escape($projectId);
    $nameEsc = $db->escape($name);
    $statusSql = $status === null ? "NULL" : "'" . $db->escape($status) . "'";
    $updatedAtSql = $updatedAt === null ? "NULL" : "'" . $db->escape($updatedAt) . "'";
    $metadataSql = $metadataJson === null ? "NULL" : "'" . $db->escape($metadataJson) . "'";

    $checkSql = "SELECT id FROM projects WHERE project_id = '{$projectIdEsc}' LIMIT 1";
    $check = $db->query($checkSql);
    $existing = $db->fetch_assoc($check);

    if ($existing) {
      $id = (int) $existing['id'];
      $sql = "UPDATE projects SET "
        . "name = '{$nameEsc}', "
        . "status = {$statusSql}, "
        . "external_updated_at = {$updatedAtSql}, "
        . "metadata_json = {$metadataSql}, "
        . "last_synced_at = NOW() "
        . "WHERE id = {$id} LIMIT 1";

      $db->query($sql);

      return [
        'action' => 'updated',
        'inventory_project_id' => $id,
        'project_id' => $projectId
      ];
    }

    $insertSql = "INSERT INTO projects (project_id, name, status, external_updated_at, metadata_json, last_synced_at) VALUES ("
      . "'{$projectIdEsc}', '{$nameEsc}', {$statusSql}, {$updatedAtSql}, {$metadataSql}, NOW()"
      . ")";

    $db->query($insertSql);
    $newId = (int) $db->insert_id();

    return [
      'action' => 'created',
      'inventory_project_id' => $newId,
      'project_id' => $projectId
    ];
  }

  public static function findSnapshotByExternalProjectId($projectId)
  {
    global $db;

    $projectIdEsc = $db->escape($projectId);

    $projectSql = "SELECT id, project_id, name, status, external_updated_at, metadata_json, last_synced_at "
      . "FROM projects WHERE project_id = '{$projectIdEsc}' LIMIT 1";
    $projectRes = $db->query($projectSql);
    $project = $db->fetch_assoc($projectRes);

    if (!$project) {
      return null;
    }

    $inventoryProjectId = (int) $project['id'];

    $itemsSql = "SELECT DISTINCT p.id, p.name, p.qr_code, p.quantity, p.shelf_id, p.media_id, p.date, p.note "
      . "FROM movements m "
      . "INNER JOIN products p ON p.id = m.product_id "
      . "WHERE m.project_id = {$inventoryProjectId} "
      . "ORDER BY p.id DESC";
    $items = find_by_sql($itemsSql);

    $movementsSql = "SELECT m.id, m.product_id, p.name AS product_name, m.quantity, m.status, m.date, m.note "
      . "FROM movements m "
      . "LEFT JOIN products p ON p.id = m.product_id "
      . "WHERE m.project_id = {$inventoryProjectId} "
      . "ORDER BY m.id DESC LIMIT 20";
    $recentMovements = find_by_sql($movementsSql);

    $metadata = null;
    if (!empty($project['metadata_json'])) {
      $decoded = json_decode($project['metadata_json'], true);
      $metadata = $decoded === null ? $project['metadata_json'] : $decoded;
    }

    return [
      'project' => [
        'inventory_project_id' => $inventoryProjectId,
        'project_id' => $project['project_id'],
        'name' => $project['name'],
        'status' => $project['status'],
        'external_updated_at' => $project['external_updated_at'],
        'metadata' => $metadata,
        'last_synced_at' => $project['last_synced_at']
      ],
      'items' => $items,
      'recent_movements' => $recentMovements,
      'last_sync_at' => $project['last_synced_at']
    ];
  }

  public static function logAudit($payload)
  {
    global $db;

    if (!self::tableExists('integration_audit')) {
      return false;
    }

    $source = $db->escape($payload['source_system'] ?? 'electroplan');
    $eventType = $db->escape($payload['event_type'] ?? 'unknown');
    $externalProjectId = isset($payload['external_project_id']) ? "'" . $db->escape((string) $payload['external_project_id']) . "'" : 'NULL';
    $httpMethod = isset($payload['http_method']) ? "'" . $db->escape((string) $payload['http_method']) . "'" : 'NULL';
    $endpoint = isset($payload['endpoint']) ? "'" . $db->escape((string) $payload['endpoint']) . "'" : 'NULL';
    $requestPayload = isset($payload['request_payload']) ? "'" . $db->escape((string) $payload['request_payload']) . "'" : 'NULL';
    $responseCode = isset($payload['response_code']) ? (int) $payload['response_code'] : 'NULL';
    $responsePayload = isset($payload['response_payload']) ? "'" . $db->escape((string) $payload['response_payload']) . "'" : 'NULL';
    $status = $db->escape($payload['status'] ?? 'ok');
    $errorMessage = isset($payload['error_message']) ? "'" . $db->escape((string) $payload['error_message']) . "'" : 'NULL';

    $sql = "INSERT INTO integration_audit ("
      . "source_system, event_type, external_project_id, http_method, endpoint, request_payload, response_code, response_payload, status, error_message"
      . ") VALUES ("
      . "'{$source}', '{$eventType}', {$externalProjectId}, {$httpMethod}, {$endpoint}, {$requestPayload}, {$responseCode}, {$responsePayload}, '{$status}', {$errorMessage}"
      . ")";

    $db->query($sql);
    return true;
  }

  public static function appendLocalLog($eventType, $data = [])
  {
    $baseDir = APP_ROOT . DS . 'integrations' . DS . 'logs';
    if (!is_dir($baseDir)) {
      @mkdir($baseDir, 0775, true);
    }

    $line = json_encode([
      'ts' => gmdate('c'),
      'event_type' => $eventType,
      'data' => $data
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $file = $baseDir . DS . 'electroplan.log';
    @file_put_contents($file, $line . PHP_EOL, FILE_APPEND);
  }

  private static function tableExists($table)
  {
    global $db;
    $tableEsc = $db->escape($table);
    $sql = "SHOW TABLES FROM " . DB_NAME . " LIKE '{$tableEsc}'";
    $res = $db->query($sql);
    return $db->num_rows($res) > 0;
  }

  private static function columnExists($table, $column)
  {
    global $db;
    $tableEsc = $db->escape($table);
    $columnEsc = $db->escape($column);
    $sql = "SHOW COLUMNS FROM `{$tableEsc}` LIKE '{$columnEsc}'";
    $res = $db->query($sql);
    return $db->num_rows($res) > 0;
  }
}

?>