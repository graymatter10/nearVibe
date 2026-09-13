<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Create Corporate Account - NearVibe</title>

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




.register-box {
    width: 420px;
    background: white;
    padding: 35px;
    border-radius: 14px;
    box-shadow: 0 5px 25px rgba(0,0,0,.08);

    margin: 150px auto 50px auto;
}


h1 {
    text-align: center;
    margin-bottom: 8px;
}


.subtitle {
    text-align: center;
    color: #6b7280;
    margin-bottom: 30px;
}


.form-group {
    margin-bottom: 18px;
}


label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 600;
}


input {
    width: 100%;
    padding: 13px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
}


.register-btn {
    width: 100%;
    padding: 13px;
    border: none;
    background: #2563eb;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}


.login-link {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
}


a {
    color: #2563eb;
    text-decoration: none;
}

</style>

</head>

<body>


<header class="top-header">


    <div class="header-logo">
        NearVibe
    </div>


    <div class="header-title">
        Resistration
    </div>


    <div class="header-role">
        Corporate
    </div>


</header>



<div class="register-box">


    <h1>Create Corporate Account</h1>


    <p class="subtitle">
        Fill in the basic information below
    </p>




    <form
        method="POST"
        action="../../Controllers/CorporateAuthController.php"
        onsubmit="return createCorporate()"
    >


      

        <input
            type="hidden"
            name="action"
            value="register"
        >





        <div class="form-group">

            <label for="corpName">
                Full Name
            </label>

            <input
                type="text"
                id="corpName"
                name="name"
                placeholder="Enter full name"
                required
            >

        </div>


        <div class="form-group">

            <label for="corpEmail">
                Email
            </label>

            <input
                type="email"
                id="corpEmail"
                name="email"
                placeholder="name@example.com"
                required
            >

        </div>



        <div class="form-group">

            <label for="corpPhone">
                Phone Number
            </label>

            <input
                type="tel"
                id="corpPhone"
                name="phone"
                placeholder="01XXXXXXXXX"
                pattern="01[0-9]{9}"
                required
            >

        </div>


        <div class="form-group">

            <label for="corpCompany">
                Company Name
            </label>

            <input
                type="text"
                id="corpCompany"
                name="company_name"
                placeholder="Enter company name"
                required
            >

        </div>


        <div class="form-group">

            <label for="corpPassword">
                Password
            </label>

            <input
                type="password"
                id="corpPassword"
                name="password"
                placeholder="Create password"
                minlength="6"
                required
            >

        </div>



        <div class="form-group">

            <label for="corpConfirmPassword">
                Confirm Password
            </label>

            <input
                type="password"
                id="corpConfirmPassword"
                name="confirm_password"
                placeholder="Repeat password"
                required
            >

        </div>



        <button
            type="submit"
            class="register-btn"
        >
            Create Account
        </button>


    </form>



    <div class="login-link">

        Already registered?

        <a href="corporate-login.php">
            Login
        </a>

    </div>

    <div class="login-link">

        Create Account as

        <a href="create-cllient-account.php">
            Client
        </a>

    </div>


</div>



<script>

function createCorporate() {


    const password =
        document.getElementById("corpPassword").value;


    const confirmPassword =
        document.getElementById("corpConfirmPassword").value;




    if (password !== confirmPassword) {

        alert("Passwords do not match!");

        return false;

    }



 

    return true;

}

</script>


</body>

</html>

