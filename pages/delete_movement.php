<?php
require_once(__DIR__ . '/../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php
$d_sale = find_by_id('movements', (int) $_GET['id']);
if (!$d_sale) {
  $session->msg("d", "Missing ID.");
  redirect('movements.php');
}
?>
<?php
$delete_id = delete_by_id('movements', (int) $d_sale['id']);
if ($delete_id) {
  $session->msg("s", "Input/output deleted.");
  redirect('movements.php');
} else {
  $session->msg("d", "Delete failed.");
  redirect('movements.php');
}
?>

