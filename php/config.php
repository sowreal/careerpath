<?php

// Define the base URL for assets and links
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// Get host (e.g., localhost or example.com)
$host = $_SERVER['HTTP_HOST'];

// Set project directory path (adjust as needed for your environment)
$projectDir = ''; // Leave empty ('') if your project is at the root level on production
                  // put /careerpath if not

// Define BASE_URL dynamically
define('BASE_URL', $protocol . $host . $projectDir);

// Difine BASE_PATH dynamically
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . $projectDir);
