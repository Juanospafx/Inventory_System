<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'funciones' . DIRECTORY_SEPARATOR . 'pure.php');

$errors = array();

/*--------------------------------------------------------------*/
/* Function for Remove escapes special
/* characters in a string for use in an SQL statement
/*--------------------------------------------------------------*/
function real_escape($str)
{
  global $con;
  $escape = mysqli_real_escape_string($con, $str);
  return $escape;
}
/*--------------------------------------------------------------*/
/* Function for Checking input fields not empty
/*--------------------------------------------------------------*/
function validate_fields($var)
{
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if (isset($val) && $val == '') {
      $errors = $field . " cannot be blank.";
      return $errors;
    }
  }
}
/*--------------------------------------------------------------*/
/* Function for Display Session Message
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg = '')
{
  $output = array();
  if (!empty($msg)) {
    foreach ($msg as $key => $value) {
      $output = "<div class=\"alert alert-{$key}\">";
      $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
      $output .= remove_junk(first_character($value));
      $output .= "</div>";
    }
    return $output;
  } else {
    return "";
  }
}
/*--------------------------------------------------------------*/
/* Function for redirect
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
  if (headers_sent() === false) {
    header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
  }

  exit();
}
/*--------------------------------------------------------------*/
/* Function for find out total saleing price, buying price and profit
/*--------------------------------------------------------------*/
function total_price($totals)
{
  $sum = 0;
  $sub = 0;
  foreach ($totals as $total) {
    $sum += $total['total_saleing_price'];
    $sub += $total['total_buying_price'];
    $profit = $sum - $sub;
  }
  return array($sum, $profit);
}
/*--------------------------------------------------------------*/
/* Function for Finding all distinct locations
/*--------------------------------------------------------------*/
function find_distinct_locations()
{
  global $db;
  $sql = "SELECT DISTINCT location FROM products WHERE location IS NOT NULL AND location != '' ORDER BY location ASC";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Finding products by location
/*--------------------------------------------------------------*/
function find_products_by_location($location)
{
  global $db;
  $sql = "SELECT id, name FROM products WHERE location = '{$location}' ORDER BY name ASC";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Finding product by QR code
/*--------------------------------------------------------------*/
function find_by_qr_code($qr_code)
{
  global $db;
  $sql = "SELECT * FROM products WHERE qr_code = '{$db->escape($qr_code)}' LIMIT 1";
  $result = find_by_sql($sql);
  return array_shift($result);
}


?>

