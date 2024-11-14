<?php
// Define the base directory for PHP includes
define('BASE_PATH', __DIR__ . '/');

// Define the base URL for assets and links
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];

// Adjust this line depending on where the root directory is on different servers
$projectDir = '/careerpath'; // Change to '' if deploying in `public_html` on Hostinger

define('BASE_URL', $protocol . $host . $projectDir);
?>
