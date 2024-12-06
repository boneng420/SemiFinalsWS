<?php
session_start();
require_once 'config.php';

if (!isset($pdo)) {
    die("Database connection failed. Check config.php file.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: ../HTML/home.html");
            exit();
        } else {
            // Add error message to session
            $_SESSION['login_error'] = "Invalid email or password";
            header("Location: ../index.html");
            exit();
        }
    } catch(PDOException $e) {
        // Log the actual error and show a generic message
        error_log("Login error: " . $e->getMessage());
        $_SESSION['login_error'] = "An error occurred. Please try again.";
        header("Location: ../index.html");
        exit();
    }
} else {
    header("Location: ../index.html");
    exit();
}
?>