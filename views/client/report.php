<?php
require_once("../../controllers/client/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/client/reportControls.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/client/head.php")?>
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
                #buttons {
                    position: absolute;
                    bottom: 15px;
                    left: 15px;
                }
                button {
                    border-radius: 7px;
                }
                #ce {
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
    <?php require("../../partials/client/header.php")?>
<div id="middle">
            <?php if(isset($message)) { echo '<p>'.h($message).'</p>'; } ?>
            <h2>Report an Issue</h2>
            <p>Submit a report about an event or system issue</p>
            <form method="POST">
                <div id="create">
                    <?php formToken(); ?>
                    <label>Related Event</label>
                    <br>
                    <select name="eid" required style="border:1px solid gray;border-radius:7px;height:40px;width:79vw;">
                        <?php foreach($events as $event) { ?>
                        <option value="<?php echo $event['eid']; ?>">
                            <?php echo h($event['title']); ?>
                        </option>
                        <?php } ?>
                    </select>
                    <br>
                    <br>
                    <label>Report Details</label>
                    <br>
                    <input type="text" name="description" maxlength="200" required placeholder="Describe the issue">
                    <br>
                    <br>
                    <div id="buttons">
                        <button type="submit" id="ce">Submit Report</button>
                        <button type="reset" id="ca">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
<?php require("../../partials/client/header-end.php")?>
</body>
</html>
