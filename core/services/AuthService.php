<?php

class AuthService
{
  public static function authenticateId($username, $password)
  {
    return authenticate($username, $password);
  }

  public static function authenticateUser($username, $password)
  {
    return authenticate_v2($username, $password);
  }
}

?>

