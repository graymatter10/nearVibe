<?php
require_once("../../controllers/client/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/client/paymentSuccessControls.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/client/head.php") ?>
<style>
        
</style>
</head>
<body>
<?php require("../../partials/client/header.php") ?>
<div id="middle">
            <?php if(isset($message)) { echo '<p class="notice">'.h($message).'</p>'; } ?>
            <h2>Payment Successful</h2>
            <div class="panel">
                <p>Ticket ID: <?php echo $ticket['tid']; ?>
                </p>
                <p>
                    <?php echo h($ticket['title']); ?>
                </p>
                <p>Method: <?php echo h($ticket['method']); ?>
                </p>
                <a href="buyTicket.php">Buy Ticket</a>
            </div>
        </div>
<?php require("../../partials/client/header-end.php") ?>
    
</body>
</html>