<?php
  $page_title = 'My profile';
  require_once(__DIR__ . '/../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
  <?php
  $user_id = (int)$_GET['id'];
  if(empty($user_id)):
    redirect('home.php',false);
  else:
    $user_p = find_by_id('users',$user_id);
  endif;
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>
<div class="row">
   <div class="col-md-4">
       <div class="card profile">
         <div class="card-body text-center bg-red">
            <img class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;" src="<?php echo base_url('uploads/users/' . $user_p['image']); ?>" alt="">
           <h3 class="text-white mt-3"><?php echo first_character($user_p['name']); ?></h3>
         </div>
        <?php if( $user_p['id'] === $user['id']):?>
         <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="edit_account.php"> <i class="fa-solid fa-pencil"></i> Edit profile</a></li>
         </ul>
       <?php endif;?>
       </div>
   </div>
</div>
<?php include_once(__DIR__ . '/../views/footer.php'); ?>
