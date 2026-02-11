<?php

/*--------------------------------------------------------------*/
/* Function for Remove html characters
/*--------------------------------------------------------------*/
function remove_junk($str)
{
  if ($str === null) {
    return '';
  }
  $str = nl2br($str);
  $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
  return $str;
}

/*--------------------------------------------------------------*/
/* Function for Uppercase first character
/*--------------------------------------------------------------*/
function first_character($str)
{
  $val = str_replace('-', " ", $str);
  $val = ucfirst($val);
  return $val;
}

/*--------------------------------------------------------------*/
/* Function for Readable date time
/*--------------------------------------------------------------*/
function read_date($date)
{
  if (empty($date)) {
    return "Never";
  }
  return date("d/m/Y", strtotime($date));
}

/*--------------------------------------------------------------*/
/* Function for Readable Make date time
/*--------------------------------------------------------------*/
function make_date()
{
  date_default_timezone_set('America/Mexico_City'); // Ajusta tu zona horaria
  return date("Y-m-d"); // Devuelve solo la fecha
}

/*--------------------------------------------------------------*/
/* Function for Readable date time
/*--------------------------------------------------------------*/
function count_id()
{
  static $count = 1;
  return $count++;
}

/*--------------------------------------------------------------*/
/* Function for Creating random string
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str = '';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for ($x = 0; $x < $length; $x++)
    $str .= $cha[mt_rand(0, strlen($cha))];
  return $str;
}

/*--------------------------------------------------------------*/
/* Function for Building base URL paths
/*--------------------------------------------------------------*/
function base_url($path = '')
{
  $base = defined('BASE_URL') ? BASE_URL : '';
  $path = ltrim($path, '/');
  if ($base === '') {
    return '/' . $path;
  }
  return $base . '/' . $path;
}

?>

