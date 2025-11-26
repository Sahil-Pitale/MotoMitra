<?php
$mysqli = new mysqli("localhost", "root", "root", "motomitra");

if ($mysqli->connect_errno) {
    die("Database Connection Failed: " . $mysqli->connect_error);
}
?>