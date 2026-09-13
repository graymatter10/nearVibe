<?php


session_start();


if (isset($_GET['reset']) && $_GET['reset'] == "success") {
    echo "<script>
            alert('Password reset successfully. Please login.');
          </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Client Login - NearVibe</title>

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    min-height: 100vh;
    background: #f5f7fb;
}




.top-header {
    width: 100%;
    height: 70px;

    background: white;

    display: flex;
    align-items: center;

    padding: 0 40px;

    border-bottom: 1px solid #e5e7eb;

    position: fixed;
    top: 0;
    left: 0;

    z-index: 1000;
}




.header-logo {
    font-size: 22px;
    font-weight: bold;
    color: #2563eb;

    width: 180px;
}




.header-title {
    font-size: 16px;
    font-weight: bold;
    color: #111827;
}




.header-role {
    margin-left: auto;

    background: #eff6ff;
    color: #2563eb;

    padding: 8px 20px;

    border-radius: 20px;

    font-size: 12px;
    font-weight: bold;
}



.login-container {
    margin: 150px auto 50px auto;
}

.login-container {
    width: 420px;
    background: white;
    padding: 35px;
    border-radius: 14px;
    box-shadow: 0 5px 25px rgba(0,0,0,.08);
}

.logo {
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
}

.subtitle {
    text-align: center;
    color: #6b7280;
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 13px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
}

input:focus {
    border-color: #2563eb;
}

.password-box {
    position: relative;
}

.password-box input {
    padding-right: 65px;
}

.show-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    color: #2563eb;
    cursor: pointer;
}

.options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    font-size: 13px;
}

.remember {
    display: flex;
    align-items: center;
    gap: 7px;
}

.remember input {
    width: auto;
}

a {
    text-decoration: none;
    color: #2563eb;
}

.login-btn {
    width: 100%;
    padding: 13px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

.register {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
}

</style>

</head>

<body>



<header class="top-header">

    
    <div class="header-logo">
        NearVibe
    </div>


    
    <div class="header-title">
        Login
    </div>


</header>


<div class="login-container">

    <div class="logo">
        Login
    </div>

    <p class="subtitle">
        Enter your credentials to continue
    </p>



    <form
        method="POST"
        action="../../Controllers/ClientAuthController.php"
        onsubmit="return clientLogin(event)"
    >

        <input
            type="hidden"
            name="action"
            value="login"
        >


        <div class="form-group">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="name@example.com"
                required
            >

        </div>


        <div class="form-group">

            <label>Password</label>

            <div class="password-box">

                <input
                    type="password"
                    name="password"
                    id="clientPassword"
                    placeholder="••••••••"
                    required
                >

                <button
                    type="button"
                    class="show-btn"
                    onclick="togglePassword()"
                >
                    Show
                </button>

            </div>

        </div>


        <div class="options">

            <label class="remember">

                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                >

                Remember me

            </label>


            <a href="client-reset-password.php">
                Forgot password?
            </a>

        </div>


        <button
            class="login-btn"
            type="submit"
        >
            Login
        </button>

    </form>


    <div class="register">

        Don't have an account?

        <a href="create-client-account.php">
            Register
        </a>

    </div>

</div>


<script>

function togglePassword() {

    const password =
        document.getElementById("clientPassword");

    const button =
        document.querySelector(".show-btn");

    if (password.type === "password") {

        password.type = "text";
        button.innerText = "Hide";

    } else {

        password.type = "password";
        button.innerText = "Show";

    }

}



function clientLogin(event) {

    const email =
        document.querySelector('input[name="email"]').value.trim();

    const password =
        document.querySelector('input[name="password"]').value;


    if (email === "" || password === "") {

        alert("Please enter email and password.");

        return false;
    }


    return true;

}

</script>

</body>
</html>