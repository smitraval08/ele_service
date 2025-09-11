<?php
// Login_datastore.php
require_once 'config.php';
session_start();   // 👈 yeh sabse important hai

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, full_name, password, role FROM eservice WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // set consistent session keys
            $_SESSION['user_id'] = (int)$row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];

            // Role based redirect
            if ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($row['role'] === 'electrician') {
                header("Location: electrician_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            // wrong password
            $_SESSION['login_error'] = "Invalid credentials.";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['login_error'] = "Invalid credentials.";
        header("Location: login.php");
        exit;
    }
}

