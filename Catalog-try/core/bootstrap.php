<?php
declare(strict_types=1);

$root = dirname(__DIR__);

// Composer autoload (if present)
$composerAutoload = $root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

// App config
$appConfigFile = __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'app.php';
if (file_exists($appConfigFile)) {
    $appConfig = require $appConfigFile;
    if (!empty($appConfig['timezone'])) {
        date_default_timezone_set($appConfig['timezone']);
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Basic autoloader for local classes
spl_autoload_register(function (string $class): void {
    $base = __DIR__;
    $paths = [
        $base . DIRECTORY_SEPARATOR . $class . '.php',
        $base . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $class . '.php',
        $base . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . $class . '.php',
        $base . DIRECTORY_SEPARATOR . 'middlewares' . DIRECTORY_SEPARATOR . $class . '.php',
        $base . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Helper functions
$helpers = $root . DIRECTORY_SEPARATOR . 'funciones' . DIRECTORY_SEPARATOR . 'response.php';
if (file_exists($helpers)) {
    require_once $helpers;
}
