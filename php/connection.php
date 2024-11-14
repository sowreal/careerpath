<?php
$host = 'db';  // This should match the service name in docker-compose
$db = 'careerpath';  // Matches the MYSQL_DATABASE in docker-compose
$user = 'user';  // Matches MYSQL_USER in docker-compose
$pass = 'password';  // Matches MYSQL_PASSWORD in docker-compose

// Old XAMPP Set Up
// $host = '127.0.0.1';
// $db = 'careerpath';  
// $user = 'root';  
// $pass = '';  

// Hostinger setup
// $host = '153.92.15.29';
// $db = 'u322404840_careerpath';  
// $user = 'u322404840_careerpath';  
// $pass = 'Careerpath@2024';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connection included.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
