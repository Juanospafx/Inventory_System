<?php
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
$shelf = find_by_id('shelves', (int) $_GET['id']);
if (!$shelf) {
    $session->msg("d", "ID del anaquel falta.");
    redirect('shelf.php');
}
?>
<?php
$delete_id = delete_by_id('shelves', (int) $shelf['id']);
if ($delete_id) {
    $session->msg("s", "Anaquel eliminado");
    redirect('shelf.php');
} else {
    $session->msg("d", "Eliminación falló");
    redirect('shelf.php');
}
?>