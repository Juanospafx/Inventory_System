<?php

require_once(__DIR__ . '/../../../core/services/ProjectService.php');

class ProjectController
{
  public static function index()
  {
    json_ok(ProjectService::all());
  }

  public static function create($payload)
  {
    if (empty($payload['name'])) {
      json_error('validation_error', 'Project name is required.');
    }
    if (ProjectService::create($payload['name'])) {
      json_ok(['message' => 'Project created.'], 201);
    }
    json_error('db_error', 'Failed to create project.');
  }

  public static function update($id, $payload)
  {
    if (empty($id)) {
      json_error('validation_error', 'Project id is required.');
    }
    if (empty($payload['name'])) {
      json_error('validation_error', 'Project name is required.');
    }
    if (ProjectService::update($id, $payload['name'])) {
      json_ok(['message' => 'Project updated.']);
    }
    json_error('db_error', 'Failed to update project.');
  }

  public static function delete($id)
  {
    if (empty($id)) {
      json_error('validation_error', 'Project id is required.');
    }
    if (ProjectService::delete($id)) {
      json_ok(['message' => 'Project deleted.']);
    }
    json_error('db_error', 'Failed to delete project.');
  }
}

?>

