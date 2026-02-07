<?php
require_once('includes/load.php');
// Verifica que el usuario tiene los permisos correctos
page_require_level(1);
?>

<?php
// Buscar el proyecto por ID
$project = find_by_id('projects', (int) $_GET['id']);
if (!$project) {
  $session->msg("d", "ID de proyecto vacío o no encontrado.");
  redirect('projects.php');
}
?>

<?php
// Eliminar el proyecto con el ID correcto
$delete_id = delete_by_id('projects', (int) $project['id']);
if ($delete_id) {
  $session->msg("s", "Proyecto eliminado exitosamente.");
  redirect('projects.php');
} else {
  $session->msg("d", "Error al eliminar el proyecto.");
  redirect('projects.php');
}
?>