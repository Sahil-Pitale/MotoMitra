<?php
require 'config.php';
require_admin();

// Fetch all users
$result = $mysqli->query("SELECT * FROM users ORDER BY created_at DESC");

if (!$result) {
    die("SQL ERROR: " . $mysqli->error);
}

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Users - MotoMitra Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-200 min-h-screen">

<div class="container mx-auto p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-yellow-400">Manage Users</h1>
        <div>
            <a href="dashboard.php" class="mr-3">Dashboard</a>
            <a href="logout.php" class="bg-gray-800 px-3 py-2 rounded">Logout</a>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg overflow-hidden">
        <table class="min-w-full text-left">
            <thead class="bg-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Membership</th>
                    <th class="p-3">Password (hashed)</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $u): ?>
                <tr class="border-b border-gray-700">
                    <td class="p-3"><?= $u['id'] ?></td>
                    <td class="p-3"><?= htmlspecialchars($u['fullname']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($u['email']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($u['Phone']) ?></td>
                    <td class="p-3"><?= $u['Membership'] ? "Yes" : "No" ?></td>
                    <td class="p-3 text-xs"><?= $u['password'] ?></td>
                    <td class="p-3">
                        <a href="user_edit.php?id=<?= $u['id'] ?>" class="text-yellow-400 mr-2">Edit</a>
                        <a href="user_delete.php?id=<?= $u['id'] ?>" class="text-red-500" onclick="return confirm('Delete user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>

</body>
</html>
