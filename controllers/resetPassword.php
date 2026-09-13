<?php

    require_once __DIR__ . "/../models/authModel.php";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: ../index.php");
        exit;
    }

    $email = trim($_POST["email"]);
    $token = trim($_POST["token"]);
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    if (empty($email) || empty($token) || empty($newPassword) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit;
    }

    if ($newPassword != $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    $user = findUserByEmailAndToken($email, $token);

    if (!$user) {
        echo "Invalid email or recovery token.";
        exit;
    }

    $hashedPassword = md5($newPassword);

    updateUserPassword($user["uid"], $hashedPassword);

    header("Location: ../login.php?reset=success");
    exit;

?>
