<?php

require_once(__DIR__ . '/../../../core/services/IntegrationProjectService.php');

class IntegrationProjectController
{
  public static function upsert($payload)
  {
    $headers = self::getHeadersSafe();

    if (!self::isAuthorized($headers)) {
      self::auditAndLog('integration.projects.upsert', $payload, 401, ['message' => 'Unauthorized integration key'], 'error');
      json_error('unauthorized', 'Invalid integration key.', null, 401);
    }

    $projectId = trim((string) ($payload['project_id'] ?? ''));
    $name = trim((string) ($payload['name'] ?? ''));
    $status = isset($payload['status']) ? trim((string) $payload['status']) : null;
    $updatedAt = isset($payload['updated_at']) ? trim((string) $payload['updated_at']) : null;
    $metadata = $payload['metadata'] ?? null;

    if ($projectId === '' || $name === '') {
      self::auditAndLog('integration.projects.upsert', $payload, 422, ['message' => 'project_id and name are required'], 'error');
      json_error('validation_error', 'project_id and name are required.', null, 422);
    }

    if (!IntegrationProjectService::hasIntegrationSchema()) {
      $message = 'Integration schema not detected. Apply Stage 1 SQL migration first.';
      self::auditAndLog('integration.projects.upsert', $payload, 500, ['message' => $message], 'error');
      json_error('integration_schema_missing', $message, null, 500);
    }

    $metadataJson = null;
    if ($metadata !== null && $metadata !== '') {
      if (is_array($metadata) || is_object($metadata)) {
        $metadataJson = json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      } else {
        $metadataString = trim((string) $metadata);
        $decoded = json_decode($metadataString, true);
        if ($decoded !== null || $metadataString === 'null') {
          $metadataJson = json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
          $metadataJson = $metadataString;
        }
      }
    }

    $result = IntegrationProjectService::upsertByExternalProjectId($projectId, $name, $status, $updatedAt, $metadataJson);
    $httpCode = $result['action'] === 'created' ? 201 : 200;

    self::auditAndLog('integration.projects.upsert', $payload, $httpCode, $result, 'ok');
    json_ok($result, $httpCode);
  }

  public static function snapshot($params)
  {
    $headers = self::getHeadersSafe();

    if (!self::isAuthorized($headers)) {
      self::auditAndLog('integration.projects.snapshot', $params, 401, ['message' => 'Unauthorized integration key'], 'error');
      json_error('unauthorized', 'Invalid integration key.', null, 401);
    }

    $projectId = trim((string) ($params['project_id'] ?? ''));
    if ($projectId === '') {
      self::auditAndLog('integration.projects.snapshot', $params, 422, ['message' => 'project_id is required'], 'error');
      json_error('validation_error', 'project_id is required.', null, 422);
    }

    if (!IntegrationProjectService::hasIntegrationSchema()) {
      $message = 'Integration schema not detected. Apply Stage 1 SQL migration first.';
      self::auditAndLog('integration.projects.snapshot', $params, 500, ['message' => $message], 'error');
      json_error('integration_schema_missing', $message, null, 500);
    }

    $snapshot = IntegrationProjectService::findSnapshotByExternalProjectId($projectId);
    if (!$snapshot) {
      self::auditAndLog('integration.projects.snapshot', $params, 404, ['message' => 'Project not found'], 'error');
      json_error('not_found', 'Project not found.', null, 404);
    }

    self::auditAndLog('integration.projects.snapshot', $params, 200, ['project_id' => $projectId], 'ok');
    json_ok($snapshot);
  }

  private static function isAuthorized($headers)
  {
    $configured = defined('INTEGRATION_SHARED_KEY') ? trim((string) INTEGRATION_SHARED_KEY) : '';
    if ($configured === '') {
      return true;
    }

    $headerKey = '';
    if (isset($headers['X-Integration-Key'])) {
      $headerKey = trim((string) $headers['X-Integration-Key']);
    } elseif (isset($headers['x-integration-key'])) {
      $headerKey = trim((string) $headers['x-integration-key']);
    }

    return hash_equals($configured, $headerKey);
  }

  private static function getHeadersSafe()
  {
    if (function_exists('getallheaders')) {
      return getallheaders();
    }

    $headers = [];
    foreach ($_SERVER as $name => $value) {
      if (strpos($name, 'HTTP_') === 0) {
        $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
        $headers[$key] = $value;
      }
    }
    return $headers;
  }

  private static function auditAndLog($eventType, $requestData, $responseCode, $responseData, $status)
  {
    $requestPayload = json_encode($requestData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $responsePayload = json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    IntegrationProjectService::logAudit([
      'source_system' => 'electroplan',
      'event_type' => $eventType,
      'external_project_id' => $requestData['project_id'] ?? null,
      'http_method' => $_SERVER['REQUEST_METHOD'] ?? null,
      'endpoint' => $_SERVER['REQUEST_URI'] ?? null,
      'request_payload' => $requestPayload,
      'response_code' => $responseCode,
      'response_payload' => $responsePayload,
      'status' => $status,
      'error_message' => $status === 'error' ? ($responseData['message'] ?? 'error') : null,
    ]);

    IntegrationProjectService::appendLocalLog($eventType, [
      'request' => $requestData,
      'response_code' => $responseCode,
      'response' => $responseData,
      'status' => $status
    ]);
  }
}

?>