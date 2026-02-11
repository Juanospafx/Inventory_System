
<?php
// -----------------------------------------------------------------------
// DEFINE SEPERATOR ALIASES
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');

define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE ROOT PATHS
// -----------------------------------------------------------------------
defined('SITE_ROOT') ? null : define('SITE_ROOT', realpath(dirname(__FILE__)));
defined('APP_ROOT') ? null : define('APP_ROOT', realpath(SITE_ROOT . DS . '..'));
define("LIB_PATH_INC", SITE_ROOT . DS);
define("FUNC_PATH", APP_ROOT . DS . 'funciones' . DS);
if (!defined('BASE_URL')) {
  $doc_root = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : '';
  if ($doc_root && strpos(APP_ROOT, $doc_root) === 0) {
    $base = str_replace('\\', '/', substr(APP_ROOT, strlen($doc_root)));
  } else {
    $base = '';
  }
  $base = rtrim($base, '/');
  define('BASE_URL', $base);
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', SITE_ROOT . DS . 'php-error.log');
error_reporting(E_ALL);


require_once(LIB_PATH_INC . 'config.php');
require_once(FUNC_PATH . 'pure.php');
require_once(LIB_PATH_INC . 'legacy_functions.php');
require_once(LIB_PATH_INC . 'session.php');
require_once(LIB_PATH_INC . 'upload.php');
require_once(LIB_PATH_INC . 'database.php');
require_once(LIB_PATH_INC . 'sql.php');
require_once(LIB_PATH_INC . 'response.php');

?>
