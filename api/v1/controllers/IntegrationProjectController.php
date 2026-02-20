<?php

require_once(__DIR__ . '/../../../core/services/IntegrationProjectService.php');

class IntegrationProjectController
{
  public static function upsert($payload)
  {
    $headers = self::getHeadersSafe();
    $requestId = self::resolveRequestId($headers);
    header('X-Request-Id: ' . $requestId);

    $auth = self::isAuthorized($headers);
    if (!$auth['ok']) {
      self::auditAndLog('integration.projects.upsert', $payload, 401, ['message' => 'Unauthorized integration key'], 'error', $requestId, $auth['mode']);
      json_error('unauthorized', 'Invalid integration key.', null, 401);
    }

    $projectId = trim((string) ($payload['project_id'] ?? ''));
    $name = trim((string) ($payload['name'] ?? ''));
    $status = isset($payload['status']) ? trim((string) $payload['status']) : null;
    $updatedAt = isset($payload['updated_at']) ? trim((string) $payload['updated_at']) : null;
    $metadata = $payload['metadata'] ?? null;

    if ($projectId === '' || $name === '') {
      self::auditAndLog('integration.projects.upsert', $payload, 422, ['message' => 'project_id and name are required'], 'error', $requestId, $auth['mode']);
      json_error('validation_error', 'project_id and name are required.', null, 422);
    }

    if (!IntegrationProjectService::hasIntegrationSchema()) {
      $message = 'Integration schema not detected. Apply Stage 1 SQL migration first.';
      self::auditAndLog('integration.projects.upsert', $payload, 500, ['message' => $message], 'error', $requestId, $auth['mode']);
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

    self::auditAndLog('integration.projects.upsert', $payload, $httpCode, $result, 'ok', $requestId, $auth['mode']);
    json_ok($result, $httpCode);
  }

  public static function snapshot($params)
  {
    $headers = self::getHeadersSafe();
    $requestId = self::resolveRequestId($headers);
    header('X-Request-Id: ' . $requestId);

    $auth = self::isAuthorized($headers);
    if (!$auth['ok']) {
      self::auditAndLog('integration.projects.snapshot', $params, 401, ['message' => 'Unauthorized integration key'], 'error', $requestId, $auth['mode']);
      json_error('unauthorized', 'Invalid integration key.', null, 401);
    }

    $projectId = trim((string) ($params['project_id'] ?? ''));
    if ($projectId === '') {
      self::auditAndLog('integration.projects.snapshot', $params, 422, ['message' => 'project_id is required'], 'error', $requestId, $auth['mode']);
      json_error('validation_error', 'project_id is required.', null, 422);
    }

    if (!IntegrationProjectService::hasIntegrationSchema()) {
      $message = 'Integration schema not detected. Apply Stage 1 SQL migration first.';
      self::auditAndLog('integration.projects.snapshot', $params, 500, ['message' => $message], 'error', $requestId, $auth['mode']);
      json_error('integration_schema_missing', $message, null, 500);
    }

    $snapshot = IntegrationProjectService::findSnapshotByExternalProjectId($projectId);
    if (!$snapshot) {
      self::auditAndLog('integration.projects.snapshot', $params, 404, ['message' => 'Project not found'], 'error', $requestId, $auth['mode']);
      json_error('not_found', 'Project not found.', null, 404);
    }

    self::auditAndLog('integration.projects.snapshot', $params, 200, ['project_id' => $projectId], 'ok', $requestId, $auth['mode']);
    json_ok($snapshot);
  }

  private static function isAuthorized($headers)
  {
    $configured = defined('INTEGRATION_SHARED_KEY') ? trim((string) INTEGRATION_SHARED_KEY) : '';
    if ($configured === '') {
      return ['ok' => true, 'mode' => 'open'];
    }

    $headerKey = self::headerValue($headers, 'X-Integration-Key');
    if ($headerKey !== '' && hash_equals($configured, $headerKey)) {
      return ['ok' => true, 'mode' => 'x-integration-key'];
    }

    $authorization = self::headerValue($headers, 'Authorization');
    if ($authorization !== '' && stripos($authorization, 'Bearer ') === 0) {
      $bearer = trim(substr($authorization, 7));
      if ($bearer !== '' && hash_equals($configured, $bearer)) {
        return ['ok' => true, 'mode' => 'bearer'];
      }
    }

    return ['ok' => false, 'mode' => 'denied'];
  }

  private static function resolveRequestId($headers)
  {
    $incoming = self::headerValue($headers, 'X-Request-Id');
    if ($incoming !== '') {
      return substr($incoming, 0, 128);
    }

    try {
      return bin2hex(random_bytes(12));
    } catch (Exception $e) {
      return uniqid('req_', true);
    }
  }

  private static function resolveClientIp()
  {
    $xff = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
    if ($xff !== '') {
      $parts = explode(',', $xff);
      return trim($parts[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? null;
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

  private static function headerValue($headers, $target)
  {
    foreach ($headers as $k => $v) {
      if (strcasecmp((string) $k, (string) $target) === 0) {
        return trim((string) $v);
      }
    }
    return '';
  }

  private static function auditAndLog($eventType, $requestData, $responseCode, $responseData, $status, $requestId, $authMode)
  {
    $maxChars = defined('INTEGRATION_LOG_MAX_CHARS') ? max(256, (int) INTEGRATION_LOG_MAX_CHARS) : 4000;

    $requestData = self::normalizeForLog($requestData, $maxChars);
    $responseData = self::normalizeForLog($responseData, $maxChars);

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
      'request_id' => $requestId,
      'client_ip' => self::resolveClientIp(),
      'auth_mode' => $authMode,
      'request' => $requestData,
      'response_code' => $responseCode,
      'response' => $responseData,
      'status' => $status
    ]);
  }

  private static function normalizeForLog($value, $maxChars)
  {
    if (is_array($value)) {
      $result = [];
      foreach ($value as $k => $v) {
        if (is_string($k) && in_array(strtolower($k), ['x-integration-key', 'authorization', 'token', 'password', 'secret'], true)) {
          $result[$k] = '[REDACTED]';
          continue;
        }
        $result[$k] = self::normalizeForLog($v, $maxChars);
      }
      return $result;
    }

    if (is_object($value)) {
      return self::normalizeForLog((array) $value, $maxChars);
    }

    if (is_string($value) && strlen($value) > $maxChars) {
      return substr($value, 0, $maxChars) . '...[truncated]';
    }

    return $value;
  }
}

?>
