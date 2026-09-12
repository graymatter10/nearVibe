<?php
require_once("../../controllers/client/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/client/createControls.php");
?>
<html>
    <head>
        <?php require("../../partials/client/head.php") ?>
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
                    width: 100px;
                    background-color: blue;
                    color: white;
                }
                #ca {
                    height: 30px;
                    margin-left: 10px;
                }
            }
        
</style>
</head>
	<body>
		<?php require("../../partials/client/header.php") ?>
<div id="middle">
            <?php if(isset($message)) { echo '<p>'.h($message).'</p>'; } ?>
            <h2>
                <?php echo $eid ? 'Edit Event' : 'Create Event'; ?>
            </h2>
            <p>Create a basic non-corporate event</p>
            <form method="POST">
                <div id="create">
                    <?php formToken(); ?>
                    <label>Event Name</label>
                    <br>
                    <input type="text" name="title" maxlength="100" required value="<?php echo h($event['title']); ?>" placeholder="Enter event name">
                    <br>
                    <br>
                    <label>Description</label>
                    <br>
                    <input type="text" name="description" maxlength="1000" value="<?php echo h($event['description']); ?>" placeholder="Short event description">
                    <br>
                    <br>
                    <label>Ticket Price</label>
                    <br>
                    <input type="number" name="tprice" min="0" step="1" required value="<?php echo h($event['tprice']); ?>" placeholder="BDT 0.00">
                    <br>
                    <br>
                    <label>Latitude</label>
                    <br>
                    <input type="number" name="latitude" min="-90" max="90" step="any" required value="<?php echo h($event['latitude']); ?>" placeholder="Enter latitude">
                    <br>
                    <br>
                    <label>Longitude</label>
                    <br>
                    <input type="number" name="longitude" min="-180" max="180" step="any" required value="<?php echo h($event['longitude']); ?>" placeholder="Enter longitude">
                    <div id="buttons">
                        <button type="submit" id="ce">
                            <?php echo $eid ? 'Save Event' : 'Create Event'; ?>
                        </button>
                        <a href="manageEvents.php">
                            <button type="button" id="ca">Cancel</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
<?php require("../../partials/client/header-end.php") ?>
	</body>
</html>
