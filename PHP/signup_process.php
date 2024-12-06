<?php
session_start();

require_once '../PHP/config.php';  

if (!isset($pdo)) {
    die("Database connection failed. Check  config.php file.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    
    // Validate password match
    if ($password !== $confirm_password) {
        header("Location: ../HTML/signup.html?error=password_mismatch");
        exit();
    }
    
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        header("Location: ../HTML/signup.html?error=email_exists");
        exit();
    }
    
    // Hash password and insert user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);
        
        // Redirect to login page on success
        header("Location: ../index.html?signup=success");
        exit();
    } catch(PDOException $e) {
        header("Location: ../HTML/signup.html?error=database");
        exit();
    }
}
?>