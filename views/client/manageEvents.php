<?php
require_once("../../controllers/client/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/client/manageEventControls.php");
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

            #top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 25px;
            }

            #top h2 {
                margin: 0 0 8px;
            }

            #top p {
                margin: 0;
                color: gray;
                font-size: 13px;
            }

            #createButton {
                background-color: blue;
                color: white;
                border: none;
                border-radius: 7px;
                padding: 12px 25px;
                font-weight: bold;
                cursor: pointer;
            }

            #searchBox {
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 10px 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
                flex-wrap: wrap;
                margin-bottom: 25px;
            }

            #search {
                width: 350px;
                max-width: 100%;
            }

            #search label {
                display: block;
                font-size: 12px;
                font-weight: bold;
                margin-bottom: 5px;
            }

            #search input {
                width: 100%;
                height: 35px;
                border: 1px solid #ddd;
                border-radius: 7px;
                padding: 0 10px;
                box-sizing: border-box;
            }

            #filters {
                display: flex;
                gap: 20px;
            }

            #filters button[aria-pressed="true"] {
                outline: 2px solid currentColor;
                outline-offset: 2px;
            }

            #filters button {
                border: none;
                border-radius: 20px;
                padding: 7px 20px;
                font-size: 12px;
                font-weight: bold;
                cursor: pointer;
            }

            #all {
                background-color: lightblue;
                color: blue;
            }

            #active {
                background-color: lightgreen;
                color: green;
            }

            #draft {
                background-color: lightyellow;
                color: brown;
            }

            #eventTable {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                border: 1px solid #ddd;
            }

            #eventTable th {
                background-color: whitesmoke;
                color: gray;
                font-size: 12px;
                text-align: left;
                padding: 13px 10px;
            }

            #eventTable td {
                padding: 15px 10px;
                border-bottom: 1px solid #ddd;
                font-size: 12px;
            }

            #actions {
                margin-top: 6px;
                font-size: 12px;
                color: blue;
            }

            #actions button {
                background-color: transparent;
                color: blue;
                border: none;
                padding: 0;
                font-size: 12px;
                cursor: pointer;
            }
        
</style>
</head>
<body>
<?php require("../../partials/client/header.php") ?>
<div id="middle">
            <?php if(isset($message)) { echo '<p>'.h($message).'</p>'; } ?>
            <div id="top">
                <div>
                    <h2>Manage Events</h2>
                    <p>View, edit and manage your created events</p>
                </div>
                <a href="createEvent.php">
                    <button id="createButton" type="button">+ Create Event</button>
                </a>
            </div>
            <div id="searchBox">
                <div id="search">
                    <label for="searchRows">Search Events</label>
                    <input type="text" id="searchRows" placeholder="Search by event name">
                </div>
                <div id="filters">
                    <button id="all" type="button">All</button>
                    <button id="active" type="button">Available</button>
                    <button id="draft" type="button">Closed</button>
                </div>
            </div>
            <table id="eventTable">
                <tr>
                    <th>Event Name</th>
                    <th>Event Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($events as $event) { ?>
                <tr data-status="<?php echo h($event['status']); ?>">
                    <td>
                        <?php echo h($event['title']); ?>
                    </td>
                    <td>
                        <?php echo h($event['type']); ?>
                    </td>
                    <td>BDT <?php echo $event['tprice']; ?>
                    </td>
                    <td>
                        <?php echo h($event['status']); ?>
                    </td>
                    <td>
                        <div id="actions">
                            <a href="createEvent.php?eid=<?php echo $event['eid']; ?>">Edit</a> | <form method="POST" style="display:inline;">
                                <?php formToken(); ?>
                                <input type="hidden" name="eid" value="<?php echo $event['eid']; ?>">
                                <button name="action" value="delete" type="submit" onclick="return confirm('Delete this event?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <p id="filterMessage" role="status"></p>
            <script>
var selectedStatus = 'ALL';
var searchInput = document.getElementById('searchRows');
var eventRows = document.querySelectorAll('#eventTable tr[data-status]');
var filterMessage = document.getElementById('filterMessage');

function filterEvents() {
    var search = searchInput.value.trim().toLowerCase();
    var visibleCount = 0;

    for (var i = 0; i < eventRows.length; i++) {
        var name = eventRows[i].cells[0].textContent.toLowerCase();
        var status = eventRows[i].getAttribute('data-status');
        var matchesStatus = selectedStatus === 'ALL' || status === selectedStatus;
        var matchesName = name.indexOf(search) !== -1;

        if (matchesStatus && matchesName) {
            eventRows[i].style.display = '';
            visibleCount++;
        } else {
            eventRows[i].style.display = 'none';
        }
    }

    filterMessage.style.display = visibleCount === 0 ? '' : 'none';
    if (selectedStatus === 'CLOSED') {
        filterMessage.textContent = 'No closed events. Event closing is not supported by this database.';
    } else if (search !== '') {
        filterMessage.textContent = 'No events match your search.';
    } else {
        filterMessage.textContent = 'No events to display.';
    }

    document.getElementById('all').setAttribute('aria-pressed', selectedStatus === 'ALL');
    document.getElementById('active').setAttribute('aria-pressed', selectedStatus === 'AVAILABLE');
    document.getElementById('draft').setAttribute('aria-pressed', selectedStatus === 'CLOSED');
}

document.getElementById('all').addEventListener('click', function () {
    selectedStatus = 'ALL';
    filterEvents();
});

document.getElementById('active').addEventListener('click', function () {
    selectedStatus = 'AVAILABLE';
    filterEvents();
});

document.getElementById('draft').addEventListener('click', function () {
    selectedStatus = 'CLOSED';
    filterEvents();
});

searchInput.addEventListener('input', filterEvents);
filterEvents();
</script>
        </div>
<?php require("../../partials/client/header-end.php") ?>
    
</body>
</html>
