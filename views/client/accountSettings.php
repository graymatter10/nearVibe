<?php
require_once("../../controllers/client/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/client/accountSettingsControls.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/client/head.php") ?>
<style>
            #middle {
                flex: 1;
                min-width: 0;
                padding: 20px;
            }

            #profile, #security {
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }

            #profile h4, #security h4 {
                margin-top: 0;
            }

            .row {
                display: flex;
                gap: 25px;
                margin-bottom: 20px;
            }

            .field {
                flex: 1;
                min-width: 0;
            }

            .field label {
                font-size: 13px;
            }

            .field input {
                width: 100%;
                height: 40px;
                border: 1px solid gray;
                border-radius: 7px;
                padding: 10px;
                box-sizing: border-box;
                margin-top: 5px;
                font-family: Arial;
            }

            #profile button, #security button {
                background-color: blue;
                color: white;
                border: 2px outset;
                border-radius: 7px;
                padding: 12px 20px;
                cursor: pointer;
            }

            #profile button:active, #security button:active {
                border-style: inset;
            }

            #security #delete {
                background-color: red;
                margin-left: 10px;
            }
        
</style>
</head>
<body>
<?php require("../../partials/client/header.php") ?>
<div id="middle">
            <?php if(isset($message)) { echo '<p>'.h($message).'</p>'; } ?>
            <h2>Account Settings</h2>
            <p>Manage your profile and security information</p>
            <div id="profile">
                <h4>Profile Information</h4>
                <form method="POST">
                    <?php formToken(); ?>
                    <input type="hidden" name="action" value="profile">
                    <div class="row">
                        <div class="field">
                            <label>Full Name</label>
                            <br>
                            <input type="text" name="name" maxlength="40" required value="<?php echo h($currentUser['name']); ?>" placeholder="Enter your full name">
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <br>
                            <input type="email" name="email" maxlength="30" required value="<?php echo h($currentUser['email']); ?>" placeholder="Enter your email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label>Phone Number</label>
                            <br>
                            <input type="text" name="phone" maxlength="14" required value="<?php echo h($currentUser['phone']); ?>" placeholder="Enter your phone number">
                        </div>
                    </div>
                    <button type="submit">Save Changes</button>
                </form>
            </div>
            <div id="security">
                <h4>Security</h4>
                <form method="POST">
                    <?php formToken(); ?>
                    <input type="hidden" name="action" value="password">
                    <div class="row">
                        <div class="field">
                            <label>Current Password</label>
                            <br>
                            <input type="password" name="currentPassword" required placeholder="Enter current password">
                        </div>
                        <div class="field">
                            <label>New Password</label>
                            <br>
                            <input type="password" name="newPassword" minlength="6" required placeholder="Enter new password">
                        </div>
                        <div class="field">
                            <label>Confirm Password</label>
                            <br>
                            <input type="password" name="confirmPassword" required placeholder="Confirm new password">
                        </div>
                    </div>
                    <button type="submit">Change Password</button>
                </form>
            </div>
        </div>
<?php require("../../partials/client/header-end.php") ?>
    
</body>
</html>