<?php


require_once __DIR__ . "/controllers/guestOnly.php";


$email = isset($_GET['email']) ? $_GET['email'] : "";
$token = isset($_GET['token']) ? $_GET['token'] : "";

?>

<!DOCTYPE html>  
<html lang="en">  
  
<head>  
  
<meta charset="UTF-8">  
  
<meta name="viewport"  
content="width=device-width, initial-scale=1.0">  
  
<title>Client Recovery Token - NearVibe</title>  
  
<style>  
  
  
  
* {  
    box-sizing: border-box;  
    margin: 0;  
    padding: 0;  
    font-family: Arial, sans-serif;  
}  
  
html,  
body {  
    width: 100%;  
    min-height: 100%;  
}  
  
body {  
    min-height: 100vh;  
    background: #f5f7fb;  
    display: flex;  
    justify-content: center;  
    align-items: flex-start;  
    padding: 13px 19px 0 19px;  
}  
  
  
  
  
.page {  
    width: 100%;  
    min-height: calc(100vh - 13px);  
    border: 1px solid #f5f7fb;  
    background: #f5f7fb;  
    position: relative;  
    padding-bottom: 7px;  
}  
  
  
  
  
.header {  
    height: 61px;  
    background: #ffffff;  
  
    display: flex;  
    align-items: center;  
  
    position: relative;  
}  
  
  
  
  
.logo {  
    position: absolute;  
    left: 31px;  
    top: 16px;  
  
    font-size: 25px;  
    font-weight: 700;  
  
    color: #2563eb;  
  
     
    
    text-decoration-thickness: 2px;  
    text-underline-offset: 5px;  
}  
  
  
  
  
.header-title {  
    position: absolute;  
    left: 208px;  
    top: 21px;  
  
    font-size: 16px;  
    font-weight: 700;  
  
    color: #111827;  
}  
  
  
  
  
.client-badge {  
    position: absolute;  
    right: 29px;  
    top: 17px;  
  
    width: 89px;  
    height: 28px;  
  
    border-radius: 20px;  
  
    background: #eff6ff;  
  
    display: flex;  
    align-items: center;  
    justify-content: center;  
  
    color: #2563eb;  
  
    font-size: 11px;  
    font-weight: 700;  
    letter-spacing: .5px;  
}  
  
  

  
.content {  
    min-height: 722px;  
  
    background: #f5f7fb;  
  
    display: flex;  
    justify-content: center;  
    align-items: flex-start;  
}  
  
  
  
  
.reset-box {  
    width: 520px;  
  
    margin-top: 11px;  
  
    background: #f5f7fb;  
  
    padding: 23px 42px 21px 42px;  
  
    border-radius: 14px;  
  
    border: 1px solid #b5b5b5;  
  
    box-shadow: none;  
}  
  

 
h1 {  
    text-align: center;  
  
    margin-bottom: 7px;  
  
    font-size: 27px;  
    line-height: 32px;  
  
    font-weight: 700;  
  
    color: #0f172a;  
}  
  
  
  
  
.subtitle {  
    text-align: center;  
  
    color: #475569;  
  
    margin-bottom: 28px;  
  
    font-size: 13px;  
  
    line-height: 18px;  
}  
  
  
  
  
.form-group {  
    margin-bottom: 17px;  
}  
  
  

  
label {  
    display: block;  
  
    font-size: 12px;  
  
    font-weight: 700;  
  
    margin-bottom: 5px;  
  
    color: #111827;  
}  
  
  
  
  
input {  
    width: 100%;  
  
    height: 41px;  
  
    padding: 11px;  
  
    border: 1px solid #aeb6c0;  
  
    border-radius: 9px;  
  
    background: #f5f7fb;  
  
    color: #64748b;  
  
    font-size: 13px;  
  
    outline: none;  
}  
  
  
input::placeholder {  
    color: #718198;  
    opacity: 1;  
}  
  
  
input:focus {  
    border-color: #94a3b8;  
    outline: none;  
}  
  
  
  
 
.validation {  
  
    background: #eee5dc;  
  
    padding: 14px 16px;  
  
    border-radius: 10px;  
  
    margin-top: 31px;  
  
    margin-bottom: 21px;  
  
    border: 1px solid #d68a25;  
  
    color: #111827;  
  
    font-size: 12px;  
  
    line-height: 23px;  
  
    min-height: 105px;  
}  
  
  
  
  
.validation::before {  
    content: "Validation rule";  
  
    display: block;  
  
    color: #b86600;  
  
    font-size: 13px;  
  
    font-weight: 700;  
  
    margin-bottom: 2px;  
}  
  
  
  
  
.reset-btn {  
  
    width: 100%;  
  
    height: 40px;  
  
    padding: 10px;  
  
    background: #2454bd;  
  
    color: white;  
  
    border: none;  
  
    border-radius: 8px;  
  
    cursor: pointer;  
  
    font-weight: bold;  
  
    font-size: 13px;  
}  
  
  
.reset-btn:hover {  
    background: #2454bd;  
}  
  
  
  
  
.back {  
  
    display: block;  
  
    text-align: center;  
  
    margin-top: 8px;  
  
    color: #0645b7;  
  
    text-decoration: none;  
  
    font-size: 12px;  
}  
  
  
.back:hover {  
    text-decoration: none;  
}  
  
  
  
  
.bottom-line {  
  
    position: absolute;  
  
    left: -1px;  
    right: -1px;  
    bottom: -1px;  
  
    height: 6px;  
  
    background: #2454bd;  
}  
  
  
  
  
@media (max-width: 700px) {  
  
    body {  
        padding: 0;  
    }  
  
    .page {  
        border: none;  
    }  
  
    .header-title {  
        left: 170px;  
    }  
  
    .reset-box {  
        width: calc(100% - 30px);  
        max-width: 520px;  
    }  
  
}  
  
  
@media (max-width: 500px) {  
  
    .logo {  
        left: 20px;  
    }  
  
    .header-title {  
        display: none;  
    }  
  
    .client-badge {  
        right: 20px;  
    }  
  
    .reset-box {  
        padding-left: 25px;  
        padding-right: 25px;  
    }  
  
}  
  
  
</style>  
  
</head>  
  
  
<body>  
  
  
<div class="page">  
  
  
     
  
    <div class="header">  
  
        <div class="logo">  
            NearVibe  
        </div>  
  
  
        <div class="header-title">  
            Reset Password  
        </div>  
   
  
    </div>  
  
  
    <div class="content">  
  
  
        <div class="reset-box">  
  
  
            <h1>  
                Recovery Token  
            </h1>  
  
  
            <p class="subtitle">  
                Your client account has been created successfully.  
                Please save this recovery token in a safe place.  
            </p>  
  
  
  
            <?php if (!empty($email)): ?>
  
                <div class="form-group">  
  
                    <label>  
                        Email  
                    </label>  
  
                    <input  
                        type="text"  
                        value="<?php echo htmlspecialchars($email); ?>"  
                        readonly  
                    >  
  
                </div>  
  
            <?php endif; ?>
  
  
  
  
            <?php if (!empty($token)): ?>
  
  
                <div class="form-group">  
  
                    <label>  
                        Your Recovery Token  
                    </label>  
  
                    <input  
                        type="text"  
                        id="recoveryToken"  
                        value="<?php echo htmlspecialchars($token); ?>"  
                        readonly  
                    >  
  
                </div>  
  
  
  
                <div class="validation">  
  
                    <div>  
                        Keep this token safe.  
                    </div>  
  
                    <div>  
                        It is required to reset your password.  
                    </div>  
  
                </div>  
  
  
  
                <button  
                    type="button"  
                    class="reset-btn"  
                    onclick="copyToken()"  
                >  
                    Copy Recovery Token  
                </button>  
  
  
           <?php else: ?>
  
  
                <div class="validation">  
  
                    <div style="color: red;">  
                        Recovery token was not found.  
                    </div>  
  
                    <div>  
                        Please create your client account again.  
                    </div>  
  
                </div>  
  
  
            <?php endif; ?>
  
  
  
  
            <a  
                class="back"  
                href="login.php"  
            >  
                Continue to Login  
            </a>  
  
  
        </div>  
  
    </div>  
  

    <div class="bottom-line"></div>  
  
  
</div>  
  
  
  
  
<script>  
  
function copyToken() {  
  
    var token =  
        document.getElementById("recoveryToken");  
  
    token.select();  
  
    token.setSelectionRange(0, 99999);  
  
    navigator.clipboard.writeText(token.value);  
  
    alert("Recovery token copied!");  
  
}  
  
</script>  
  
  
</body>  
</html>