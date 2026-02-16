﻿<?php
  $page_title = 'Home Page';
  require_once(__DIR__ . '/../includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
  if((int)current_user()['user_level'] === 1){
    redirect('admin.php', false);
  }
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
 <div class="col-md-12">
    <div class="panel">
      <div class="jumbotron text-center">
         <h1>This is your new home page</h1>
     
      </div>
    </div>
 </div>
</div>
<?php include_once(__DIR__ . '/../views/footer.php'); ?>
