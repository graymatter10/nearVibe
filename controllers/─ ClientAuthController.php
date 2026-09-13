<?php

session_start();

require_once __DIR__ . "/../models/dbConnect.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Client.php";

$userModel = new User($conn);
$clientModel = new Client($conn);


if (isset($_POST['action']) && $_POST['action'] == "register") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

   
    if (
        empty($name) ||
        empty($email) ||
        empty($phone) ||
        empty($password) ||
        empty($confirmPassword)
    ) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    if ($password != $confirmPassword) {
        die("Passwords do not match.");
    }

    if ($userModel->emailExists($email)) {
        die("Email already exists.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $type = "CLIENT";

    
    $uid = $userModel->createUser(
        $name,
        $email,
        $hashedPassword,
        $phone,
        $type
    );

    if ($uid == false) {
        die("Failed to create account.");
    }

   
    $clientCreated = $clientModel->createClient($uid);

    if (!$clientCreated) {
        die("Client account creation failed.");
    }

    $token = bin2hex(random_bytes(16));

   
    $tokenSaved = $userModel->saveResetToken($uid, $token);

    if (!$tokenSaved) {
        die("Failed to generate recovery token.");
    }

    
    header(
        "Location: ../views/client-recovery-token.php?email="
        . urlencode($email)
        . "&token="
        . urlencode($token)
    );

    exit();
}



if (isset($_POST['action']) && $_POST['action'] == "login") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }

   
    $user = $userModel->findByEmailAndType(
        $email,
        "CLIENT"
    );

    if (!$user) {
        die("Client account not found.");
    }

    

    $passwordCorrect = false;

    if (password_verify($password, $user['password'])) {

        $passwordCorrect = true;

    } elseif (md5($password) === $user['password']) {

        
        $passwordCorrect = true;
    }


    if (!$passwordCorrect) {
        die("Incorrect password.");
    }



    $_SESSION['uid'] = $user['uid'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['type'] = $user['type'];
   

    if (isset($_POST['remember'])) {

        setcookie(
            "nearvibe_user",
            $user['email'],
            time() + (30 * 24 * 60 * 60),
            "/"
        );
    }


    header("Location: ../views/dashboard/client-dashboard.php");

    exit();
}


if (
    isset($_POST['action']) &&
    $_POST['action'] == "recovery_token"
) {

    $email = trim($_POST['email']);

    if (empty($email)) {
        die("Email is required.");
    }

   
    $user = $userModel->findByEmailAndType(
        $email,
        "CLIENT"
    );

    if (!$user) {
        die("Client account not found.");
    }

    
    $token = bin2hex(random_bytes(16));

   
    if (!$userModel->saveResetToken($user['uid'], $token)) {
        die("Failed to generate recovery token.");
    }


    header(
        "Location: ../views/client-recovery-token.php?email="
        . urlencode($email)
        . "&token="
        . urlencode($token)
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


  
    $user = $userModel->findByEmailAndToken(
        $email,
        $token
    );


    if (!$user) {
        die("Invalid email or recovery token.");
    }


   
    $hashedPassword = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );


    
    $updated = $userModel->updatePassword(
        $user['uid'],
        $hashedPassword
    );


    if (!$updated) {
        die("Failed to reset password.");
    }



    header(
        "Location: ../views/client-login.php?reset=success"
    );

    exit();
}

?>