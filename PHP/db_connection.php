<?php
// db_connection.php
$host = 'localhost';
$username = 'root';  // Default phpMyAdmin username
$password = '';      // Default phpMyAdmin password (usually empty)
$database = 'contact_form_db';  // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>