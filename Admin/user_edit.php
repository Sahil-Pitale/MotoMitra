<?php
require 'config.php';
require_admin();

$id = $_GET['id'] ?? 0;
$res = $mysqli->query("SELECT * FROM users WHERE id=$id");
$user = $res->fetch_assoc();

if (!$user) die("User not found");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['Phone'];
    $membership = $_POST['membership'];
    $pass = $_POST['password'];

    if (!empty($pass)) {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $mysqli->query("UPDATE users SET name='$name', email='$email', Phone='$Phone', membership='$membership', password='$hashed' WHERE id=$id");
    } else {
        $mysqli->query("UPDATE users SET name='$name', email='$email', Phone='$Phone', membership='$membership' WHERE id=$id");
    }

    header("Location: users.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit User</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-200 min-h-screen p-6">

<h1 class="text-3xl font-bold mb-6 text-yellow-400">Edit User</h1>

<form method="post" class="max-w-lg bg-gray-800 p-6 rounded">

    <label class="block mb-2">Name</label>
    <input name="name" value="<?= htmlspecialchars($user['name']) ?>" class="w-full p-3 mb-3 bg-gray-700 rounded">

    <label class="block mb-2">Email</label>
    <input name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full p-3 mb-3 bg-gray-700 rounded">

    <label class="block mb-2">Phone</label>
    <input name="Phone" value="<?= htmlspecialchars($user['Phone']) ?>" class="w-full p-3 mb-3 bg-gray-700 rounded">

    <label class="block mb-2">Membership</label>
    <select name="membership" class="w-full p-3 mb-3 bg-gray-700 rounded">
        <option value="0" <?= $user['membership']==0?'selected':'' ?>>No</option>
        <option value="1" <?= $user['membership']==1?'selected':'' ?>>Yes</option>
    </select>

    <label class="block mb-2">Change Password (optional)</label>
    <input name="password" type="password" placeholder="Leave empty to keep same" class="w-full p-3 mb-4 bg-gray-700 rounded">

    <button class="bg-yellow-400 px-5 py-3 rounded text-black font-bold">Save Changes</button>
</form>

</body>
</html>
