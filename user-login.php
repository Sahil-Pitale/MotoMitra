<?php
include "Admin/db.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($mysqli, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["fullname"];

        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>User Login</title>
</head>
<body class="bg-gray-900 text-white flex justify-center items-center min-h-screen">

<div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md">

    <h2 class="text-3xl font-bold mb-6 text-center">Login</h2>

    <?php if ($error): ?>
        <p class="bg-red-500 p-2 rounded text-center mb-3"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">

        <label class="block mb-2">Email</label>
        <input type="email" name="email" required
               class="w-full p-3 mb-4 bg-gray-700 rounded">

        <label class="block mb-2">Password</label>
        <input type="password" name="password" required
               class="w-full p-3 mb-4 bg-gray-700 rounded">

        <button class="w-full bg-yellow-400 text-black p-3 rounded font-bold hover:bg-yellow-300 transition">
            Login
        </button>
    </form>

    <p class="text-center mt-4 text-gray-400">
        Don't have an account?
        <a href="user-signup.php" class="text-yellow-400">Sign Up</a>
    </p>

</div>

</body>
</html>
