<?php

    require_once __DIR__ . "/../../models/authModel.php";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: ../../index.php");
        exit;
    }

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $rawPassword = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if (empty($name) || empty($email) || empty($phone) || empty($rawPassword) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please insert a valid email";
        exit;
    }

    if ($rawPassword != $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    if (emailExists($email)) {
        echo "Email already exists.";
        exit;
    }

    $hashedPassword = md5($rawPassword);

    $uid = createUser($name, $email, $hashedPassword, $phone, "CLIENT");

    if (!$uid) {
        echo "Failed to create account.";
        exit;
    }

    createClientRow($uid);

    $token = bin2hex(random_bytes(16));
    saveResetToken($uid, $token);

    header("Location: ../../recovery-token.php?email=" . urlencode($email) . "&token=" . urlencode($token));
    exit;

?>
