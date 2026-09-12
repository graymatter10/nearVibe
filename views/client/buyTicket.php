<?php
require_once("../../controllers/client/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/client/buyTicketControls.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/client/head.php") ?>
<style>
            #middle {
                padding: 25px 30px;
                flex: 1;
                min-width: 0;
            }

            #middle h2 {
                margin: 0 0 8px;
            }

            #description {
                color: gray;
                font-size: 13px;
                margin: 0 0 40px;
            }

            #events {
                display: flex;
                gap: 25px;
                flex-wrap: wrap;
            }

            .event {
                width: 280px;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 12px;
                overflow: hidden;
            }

            .picture {
                height: 90px;
                background-color: #eff6ff;
                border-radius: 12px;
            }

            .details {
                padding: 15px;
            }

            .details h4 {
                margin: 0 0 12px;
                font-size: 16px;
            }

            .details p {
                color: gray;
                font-size: 12px;
                margin: 0 0 10px;
            }

            .details h3 {
                margin: 16px 0 6px;
                font-size: 18px;
            }

            .details a {
                display: block;
                background-color: blue;
                color: white;
                border-radius: 7px;
                font-size: 13px;
                font-weight: bold;
                text-align: center;
                text-decoration: none;
                padding: 12px 0;
            }
        
</style>
</head>
<body>
<?php require("../../partials/client/header.php") ?>
<div id="middle">
            <h2>Corporate Events</h2>
            <?php if(isset($message)) { echo "<p>".h($message)."</p>"; } ?>
            <p id="description">Browse available events and purchase tickets</p>
            <div id="events">
                <?php foreach ($events as $event) { ?>
                <div class="event">
                    <div class="picture">
                    </div>
                    <div class="details">
                        <h4>
                            <?php echo h($event['title']); ?>
                        </h4>
                        <p>
                            <?php echo h($event['description']); ?>
                        </p>
                        <p>Location: <?php echo h($event['latitude']); ?>, <?php echo h($event['longitude']); ?>
                        </p>
                        <h3>BDT <?php echo $event['tprice']; ?>
                        </h3>
                        <a href="payment.php?eid=<?php echo $event['eid']; ?>">Buy Ticket</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
<?php require("../../partials/client/header-end.php") ?>
    
</body>
</html>