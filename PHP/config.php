<?php
$host = "localhost";
$dbname = "user_auth";  
$username = "root";    
$password = "";         

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>