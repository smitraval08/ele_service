<?php
// config.php — single DB connection file
if (session_status() === PHP_SESSION_NONE) session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // XAMPP default (leave blank) — change if you use a password
$DB_NAME = 'electric_service';
$DB_PORT = 3306;

$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
if ($con->connect_error) {
    // In production don't echo credentials; for dev show simple message
    die("Database connection failed: " . $con->connect_error);
}
// Ensure proper charset
$con->set_charset('utf8mb4');
