<?php

session_start();

?>
<!DOCTYPE html> 
<html lang="en"> 
 
<head> 
 
<meta charset="UTF-8"> 
 
<meta name="viewport" 
content="width=device-width, initial-scale=1.0"> 
 
<title>Create Client Account - NearVibe</title> 
 
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
 
.register-btn { 
    width: 100%; 
    padding: 13px; 
    border: none; 
    background: #2563eb; 
    color: white; 
    border-radius: 8px; 
    cursor: pointer; 
    font-weight: bold; 
    margin-top: 8px; 
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
        Registration 
    </div> 
 
 
    
    <div class="header-role"> 
        Client 
    </div> 
 
</header> 
 
<div class="register-box"> 
 
    <h1>Create Client Account</h1> 
 
    <p class="subtitle"> 
        Fill in the basic information below 
    </p> 
 
 

    <form 
        method="POST" 
        action="../../Controllers/ClientAuthController.php"
        onsubmit="return createClient(event)"
    > 

        
        <input 
            type="hidden" 
            name="action" 
            value="register"
        >
 
        <div class="form-group"> 
 
            <label>Full Name</label> 
 
            <input 
                type="text" 
                name="name"
                placeholder="Enter full name" 
                required 
            > 
 
        </div> 
 
 
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
 
            <label>Phone Number</label> 
 
            <input 
                type="tel" 
                name="phone"
                placeholder="01XXXXXXXXX" 
                pattern="01[0-9]{9}" 
                required 
            > 
 
        </div> 
 
 
        <div class="form-group"> 
 
            <label>Password</label> 
 
            <input 
                type="password" 
                name="password"
                id="clientRegPassword" 
                placeholder="Create password" 
                minlength="6" 
                required 
            > 
 
        </div> 
 
 
        <div class="form-group"> 
 
            <label>Confirm Password</label> 
 
            <input 
                type="password" 
                name="confirm_password"
                id="clientConfirmPassword" 
                placeholder="Repeat password" 
                required 
            > 
 
        </div> 
 
 
        <button 
            class="register-btn" 
            type="submit" 
        > 
            Create Account 
        </button> 
 
    </form> 
 
 
    <div class="login-link"> 
 
        Already registered? 
 
        <a href="login.php"> 
            Login 
        </a> 
 
    </div> 
    <div class="login-link"> 
 
        Create Account as  
 
        <a href="create-corporate-account.php"> 
            Corporate 
        </a> 
 
    </div> 
 
</div> 
 
 
<script> 
 
function createClient(event) { 
 
    const password = 
        document.getElementById("clientRegPassword").value; 
 
    const confirmPassword = 
        document.getElementById("clientConfirmPassword").value; 
 
    if (password !== confirmPassword) { 
 
        event.preventDefault();

        alert("Passwords do not match!"); 
 
        return false; 
 
    } 
 

    return true;

} 
 
</script> 
 
</body> 
</html>