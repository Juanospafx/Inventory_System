<?php
  require_once(__DIR__ . '/../core/bootstrap.php');
  if(!$session->logout()) {redirect(base_url('pages/index.php'));}
?>
