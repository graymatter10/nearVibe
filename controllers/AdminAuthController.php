<?php

session_start();

require_once __DIR__ . "/../models/dbConnect.php";
require_once __DIR__ . "/../models/User.php";

$userModel = new User($conn);


if (
    isset($_POST['action']) &&
    $_POST['action'] == "login"
) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];



    if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }


   
    $admin = $userModel->findByEmailAndType(
        $email,
        "ADMIN"
    );


    if (!$admin) {
        die("Admin account not found.");
    }


    $passwordCorrect = false;


    if (
        password_verify(
            $password,
            $admin['password']
        )
    ) {

        $passwordCorrect = true;

    } elseif (
        md5($password) === $admin['password']
    ) {

      
        $passwordCorrect = true;
    }


    if (!$passwordCorrect) {
        die("Incorrect password.");
    }
    
    $_SESSION['uid'] = $admin['uid'];
    $_SESSION['name'] = $admin['name'];
    $_SESSION['email'] = $admin['email'];
    $_SESSION['type'] = $admin['type'];



    if (isset($_POST['remember'])) {

        setcookie(
            "nearvibe_user",
            $admin['email'],
            time() + (30 * 24 * 60 * 60),
            "/"
        );
    }


    

    header(
        "Location: ../views/dashboard/admin-dashboard.php"
    );

    exit();
}




if (
    isset($_POST['action']) &&
    $_POST['action'] == "reset_password"
) {

    $email = trim($_POST['email']);
    $token = trim($_POST['token']);

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];


    
    if (
        empty($email) ||
        empty($token) ||
        empty($newPassword) ||
        empty($confirmPassword)
    ) {
        die("All fields are required.");
    }


    
    if ($newPassword != $confirmPassword) {
        die("Passwords do not match.");
    }


    

    $admin = $userModel->findByEmailAndToken(
        $email,
        $token
    );


    if (!$admin) {
        die("Invalid email or recovery token.");
    }

    if ($admin['type'] != "ADMIN") {
        die("This is not an admin account.");
    }


    
    $hashedPassword = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );


    
    $updated = $userModel->updatePassword(
        $admin['uid'],
        $hashedPassword
    );


    if (!$updated) {
        die("Failed to reset password.");
    }


    

    header(
        "Location: ../views/admin-login.php?reset=success"
    );

    exit();
}

?>