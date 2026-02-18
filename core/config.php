<?php
/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| 
|
|
*/

define('DB_HOST', 'localhost');          // Set database host
define('DB_USER', 'brightro_brightronix_inv');             // Set database user
define('DB_PASS', 'rootadmin01');             // Set database password
define('DB_NAME', 'brightro_brightronix_inv');        // Set database name

// Shared secret for integration endpoints (header: X-Integration-Key).
// Empty by default to keep backward compatibility in local/dev.
define('INTEGRATION_SHARED_KEY', getenv('INTEGRATION_SHARED_KEY') ?: '');

/*
define('DB_HOST', 'localhost');          // Set database host
define('DB_USER', 'root');             // Set database user
define('DB_PASS', '');             // Set database password
define('DB_NAME', 'brightro_brightronix_inv');        // Set database name
*/
?>

