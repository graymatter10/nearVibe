<?php

require_once("../../controllers/admin/sessionManage.php");
require_once("../../models/usersModel.php");

$currentUser=getUser($_SESSION["uid"]);

require_once("../../partials/formHelper.php");
require("../../controllers/admin/manageEventControls.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<?php require("../../partials/admin/head.php") ?>

<style>

#middle
{
    padding:25px 30px;
    flex:1;
    min-width:0;
}

#top
{
    margin-bottom:25px;
}

#top h2
{
    margin:0 0 8px;
}

#top p
{
    margin:0;
    color:gray;
    font-size:13px;
}

#searchBox
{
    background-color:white;
    border:1px solid #ddd;
    border-radius:10px;
    padding:10px 15px;
    margin-bottom:25px;
}

#search
{
    width:350px;
    max-width:100%;
}

#search label
{
    display:block;
    font-size:12px;
    font-weight:bold;
    margin-bottom:5px;
}

#search input
{
    width:100%;
    height:35px;
    border:1px solid #ddd;
    border-radius:7px;
    padding:0 10px;
    box-sizing:border-box;
}

#eventTable
{
    width:100%;
    border-collapse:collapse;
    background-color:white;
    border:1px solid #ddd;
}

#eventTable th
{
    background-color:whitesmoke;
    color:gray;
    font-size:12px;
    text-align:left;
    padding:13px 10px;
}

#eventTable td
{
    padding:15px 10px;
    border-bottom:1px solid #ddd;
    font-size:12px;
}

#actions
{
    margin-top:6px;
    font-size:12px;
    color:blue;
}

#actions button
{
    background-color:transparent;
    color:blue;
    border:none;
    padding:0;
    font-size:12px;
}

</style>

</head>

<body>

<?php require("../../partials/admin/header.php") ?>

<div id="middle">

    <?php

    if(isset($message))
    {
        echo "<p>".h($message)."</p>";
    }

    ?>

    <div id="top">

        <h2>Manage All Events</h2>

        <p>Review and control every event in the system</p>

    </div>

    <div id="searchBox">

        <div id="search">

            <label for="searchRows">Search Event</label>

            <input
                type="text"
                id="searchRows"
                placeholder="Search by event name"
            >

        </div>

    </div>

    <table id="eventTable">

        <tr>

            <th>Event ID</th>

            <th>Event Name</th>

            <th>Type</th>

            <th>Status</th>

            <th>Actions</th>

        </tr>

        <?php

        foreach($events as $event)
        {

        ?>

        <tr>

            <td>
                <?php echo $event["eid"]; ?>
            </td>

            <td>
                <?php echo h($event["title"]); ?>
            </td>

            <td>
                <?php echo h($event["type"]); ?>
            </td>

            <td>
                <?php echo h($event["status"]); ?>
            </td>

            <td>

                <div id="actions">

                    <form method="POST">

                        <?php formToken(); ?>

                        <input
                            type="hidden"
                            name="eid"
                            value="<?php echo $event["eid"]; ?>"
                        >

                        <button
                            type="submit"
                            name="action"
                            value="delete"
                            onclick="return confirm('Delete this event?')"
                        >
                            Delete Event
                        </button>

                    </form>

                </div>

            </td>

        </tr>

        <?php

        }

        ?>

    </table>

    <script src="../../js/search.js"></script>

</div>

<?php require("../../partials/admin/header-end.php") ?>

</body>

</html>