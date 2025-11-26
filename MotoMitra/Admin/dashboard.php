<?php
require 'config.php';
require_admin();

// Total users
$result = $mysqli->query("SELECT COUNT(*) AS total FROM users");
$total_users = $result->fetch_assoc()['total'];

// Active memberships
$result = $mysqli->query("SELECT COUNT(*) AS total FROM users WHERE Membership = 1");
$members_count = $result->fetch_assoc()['total'];

// Placeholder (you can add inspections table later)
$inspections_count = 0;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Dashboard - MotoMitra</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-200 min-h-screen">

<div class="container mx-auto p-6">

<header class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-yellow-400">MotoMitra Admin Dashboard</h1>
    <div>
        <span class="mr-4">Welcome, Admin</span>
        <a href="logout.php" class="bg-gray-800 px-4 py-2 rounded">Logout</a>
    </div>
</header>

<!-- Stats -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gray-800 p-6 rounded-lg">
        <div class="text-sm text-gray-400">Total Users</div>
        <div class="text-3xl font-bold"><?= $total_users ?></div>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg">
        <div class="text-sm text-gray-400">Active Memberships</div>
        <div class="text-3xl font-bold"><?= $members_count ?></div>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg">
        <div class="text-sm text-gray-400">Total Inspections</div>
        <div class="text-3xl font-bold"><?= $inspections_count ?></div>
    </div>
</div>

<!-- Links -->
<div class="grid md:grid-cols-2 gap-6">
    <a href="users.php" class="block bg-gray-800 p-6 rounded-lg hover:bg-gray-700">Manage Users</a>
    <a href="inspection.html" class="block bg-gray-800 p-6 rounded-lg hover:bg-gray-700">View Inspections</a>
</div>

</div>

</body>
</html>
