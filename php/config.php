<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define BASE_URL as root
define('BASE_URL', '/');

// Define INCLUDE_PATH for server-side includes
define('INCLUDE_PATH', __DIR__ . '/includes/');
?>
