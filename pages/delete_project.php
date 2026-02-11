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
  $session->msg("d", "ID de proyecto vac??o o no encontrado.");
  redirect('projects.php');
}
?>

<?php
// Eliminar el proyecto con el ID correcto
$delete_id = ProjectService::delete((int) $project['id']);
if ($delete_id) {
  $session->msg("s", "Proyecto eliminado exitosamente.");
  redirect('projects.php');
} else {
  $session->msg("d", "Error al eliminar el proyecto.");
  redirect('projects.php');
}
?>
