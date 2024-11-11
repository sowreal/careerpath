<?php
$host = '127.0.0.1';
$db = 'careerpath';  
$user = 'root';  
$pass = '';  

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connection included.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
