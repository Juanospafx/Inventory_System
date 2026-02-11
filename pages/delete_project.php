<?php
require_once(__DIR__ . '/../includes/load.php');
require_once(__DIR__ . '/../core/services/ProjectService.php');
// Verifica que el usuario tiene los permisos correctos
page_require_level(1);
?>

<?php
// Buscar el proyecto por ID
$project = ProjectService::find((int) $_GET['id']);
if (!$project) {
  $session->msg("d", "Project ID is empty or not found.");
  redirect('projects.php');
}
?>

<?php
// Delete el proyecto con el ID correcto
$delete_id = ProjectService::delete((int) $project['id']);
if ($delete_id) {
  $session->msg("s", "Project deleted successfully.");
  redirect('projects.php');
} else {
  $session->msg("d", "Error deleting project.");
  redirect('projects.php');
}
?>

