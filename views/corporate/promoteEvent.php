<?php
require_once("../../controllers/corporate/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/corporate/promoteEventControls.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/corporate/head.php") ?>
<style>
            #create {
                height: 60vh;
                width: 80vw;
                background-color: white;
                border-radius: 20px;
                padding: 15px;
                position: relative;
                input {
                    border: 1px solid gray;
                    border-radius: 7px;
                    height: 40px;
                    width: 79vw;
                }
                #row {
                    display: flex;
                    gap: 20px;
                    margin-bottom: 20px;
                    input {
                        width: 38vw;
                    }
                }
                #budget {
                    width: 38vw;
                }
                #buttons {
                    position: absolute;
                    bottom: 15px;
                    left: 15px;
                }
                button {
                    border-radius: 7px;
                    cursor: pointer;
                }
                #start {
                    height: 30px;
                    width: 170px;
                    background-color: blue;
                    color: white;
                    white-space: nowrap;
                }
                #ca {
                    height: 30px;
                    width: 100px;
                    margin-left: 10px;
                }
            }
        
</style>
</head>
<body>
<?php require("../../partials/corporate/header.php") ?>
<div id="middle">
            <?php if(isset($message)) { echo '<p>'.h($message).'</p>'; } ?>
            <h2>Promote Event</h2>
            <p>Create a simple promotion for one of your corporate events</p>
            <form method="POST">
                <div id="create">
                    <?php formToken(); ?>
                    <div id="row">
                        <div>
                            <label>Select Event</label>
                            <br>
                            <select name="eid" required style="border:1px solid gray;border-radius:7px;height:40px;width:38vw;">
                                <?php foreach($events as $event) { ?>
                                <option value="<?php echo $event['eid']; ?>">
                                    <?php echo h($event['title']); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label>Promotion Duration</label>
                            <br>
                            <input type="number" name="duration" placeholder="Enter number of days" min="1" required>
                        </div>
                    </div>
                    <label>Budget</label>
                    <br>
                    <input type="number" id="budget" name="amount" placeholder="BDT 0" min="1" step="1" required>
                    <br>
                    <br>
                    <div id="buttons">
                        <button type="submit" id="start">Start Promotion</button>
                        <button type="reset" id="ca">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
<?php require("../../partials/corporate/header-end.php") ?>

</body>
</html>