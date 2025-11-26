<?php
require 'config.php';
require_admin();

$id = $_GET['id'] ?? 0;
$mysqli->query("DELETE FROM users WHERE id = $id");

header("Location: users.php");
exit;
?>
