<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === "admin" && $password === "admin1325") {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_name'] = "Admin";
    header("Location: dashboard.php");
    exit;
} else {
    $err = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login - MotoMitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen text-gray-200">

<div class="bg-gray-800 p-8 rounded-2xl w-full max-w-md shadow-xl">
    <h2 class="text-2xl text-yellow-400 font-bold mb-6 text-center">MotoMitra Admin Login</h2>

   <?php if (!empty($error)): ?>
    <div class="bg-red-600 text-white p-2 rounded mb-4 text-center">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>


    <form method="POST">
        <label class="block mb-2 font-semibold">Username</label>
        <input type="text" name="username" required class="w-full p-3 rounded bg-gray-700 mb-4" placeholder="Enter username">

        <label class="block mb-2 font-semibold">Password</label>
        <input type="password" name="password" required class="w-full p-3 rounded bg-gray-700 mb-6" placeholder="Enter password">

        <button class="w-full py-3 bg-yellow-400 text-black rounded font-bold hover:bg-yellow-300 transition">
            Login
        </button>
    </form>
</div>

</body>
</html>
