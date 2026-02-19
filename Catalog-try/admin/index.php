<?php
/**
* @author evilnapsis
**/

define("ROOT", dirname(__FILE__));

$debug= false;
if($debug){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require_once __DIR__ . '/../core/bootstrap.php';

ob_start();
Core::$root = "admin/";

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
// Core::$debug_sql = true;

$lb = new Lb();
$lb->start();
?>
