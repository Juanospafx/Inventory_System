<?php
  require_once(__DIR__ . '/../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('user_groups',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Group deleted.");
      redirect('group.php');
  } else {
      $session->msg("d","Delete failed.");
      redirect('group.php');
  }
?>


