<?php

    require_once __DIR__ . "/../models/authModel.php";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: ../index.php");
        exit;
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo "Please insert a valid email";
        exit;
    }

    $email = $_POST["email"];
    $rawPassword = $_POST["password"];
    $user = findUserByEmailFull($email);

    if (!$user) {
        echo "No account found with this email";
        exit;
    }

    if (!verifyPassword($rawPassword, $user["password"])) {
        echo "Incorrect password";
        exit;
    }

    session_start();
    $_SESSION["uid"] = $user["uid"];
    $_SESSION["email"] = $email;

    switch ($user["type"]) {
        case "CLIENT":
            header("Location: ../views/client/dashboard.php");
            break;
        case "CORPORATE":
            header("Location: ../views/corporate/dashboard.php");
            break;
        case "ADMIN":
            header("Location: ../views/admin/dashboard.php");
            break;
        default:
            header("Location: ../index.php");
    }
    exit;

?>