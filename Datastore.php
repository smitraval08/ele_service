<?php
// Datastore.php (registration)
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['full_name'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    if (strlen($password) < 6) {
        die("Password must be at least 6 characters.");
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO eservice (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $hashed, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: login.php");
        exit;
    } else {
        // handle duplicate email gracefully
        if ($con->errno === 1062) {
            die("Email already registered.");
        }
        die("Registration failed: " . $stmt->error);
    }
    // don't close $con here (managed by config file)
}
