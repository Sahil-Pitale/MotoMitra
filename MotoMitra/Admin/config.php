<?php
// Start session safely
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// DATABASE CONNECTION
$host = "localhost";
$user = "root";
$pass = "root";   // if your WAMP password is empty, replace with ""
$db   = "motomitra";

$mysqli = new mysqli($host, $user, $pass, $db);

// Check DB connection
if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// FUNCTION: Allow only logged-in admins
function require_admin() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }
}
?>
