<?php include_once(__DIR__ . '/../core/bootstrap.php'); ?>
<?php require_once(__DIR__ . '/../core/services/AuthService.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

if(empty($errors)){
  $user_id = AuthService::authenticateId($username, $password);
  if($user_id){
    //create session with id
     $session->login($user_id);
    //Update Sign in time
     updateLastLogIn($user_id);
     $session->msg("s", "Welcome to Brigtronix-INV.");
     redirect(base_url('pages/home.php'), false);

  } else {
    $session->msg("d", "Incorrect username and/or password.");
    redirect(base_url('pages/index.php'), false);
  }

} else {
   $session->msg("d", $errors);
   redirect(base_url('pages/index.php'), false);
}

?>

