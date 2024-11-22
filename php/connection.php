<?php
// Docker setup 
$host = 'db';  // This should match the service name in docker-compose
$db = 'careerpath';  // Matches the MYSQL_DATABASE in docker-compose
$user = 'user';  // Matches MYSQL_USER in docker-compose
$pass = 'password';  // Matches MYSQL_PASSWORD in docker-compose
$charset = 'utf8mb4';

// Old XAMPP setup
// $host = '127.0.0.1';
// $db = 'careerpath';  
// $user = 'root';  
// $pass = '';  

// Hostinger setup
// $host = '153.92.15.29';
// $db = 'u322404840_careerpath';  
// $user = 'u322404840_careerpath';  
// $pass = 'Careerpath@2024';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation of prepared statements
];
try {
     $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>