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
define('DB_USER', 'root');             // Set database user
define('DB_PASS', '');             // Set database password
define('DB_NAME', 'brightro_brightronix_inv');        // Set database name

// Shared secret for integration endpoints.
// Primary header: X-Integration-Key
// Alternative auth: Authorization: Bearer <secret>
define('INTEGRATION_SHARED_KEY', getenv('INTEGRATION_SHARED_KEY') ?: '');

// Local integration log controls
// Max chars stored per JSON payload in logs/audit context.
define('INTEGRATION_LOG_MAX_CHARS', (int) (getenv('INTEGRATION_LOG_MAX_CHARS') ?: 4000));

/*
define('DB_HOST', 'localhost');          // Set database host
define('DB_USER', 'root');             // Set database user
define('DB_PASS', '');             // Set database password
define('DB_NAME', 'brightro_brightronix_inv');        // Set database name
*/
?>

