<?php require_once __DIR__ . "/../../controllers/client/sessionManage.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/client/head.php") ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #middle h1 {
        margin: 0 0 6px;
        font-size: 24px;
    }

    #middle h2 {
        font-size: 18px;
        margin: 0 0 15px;
    }

    .subtitle {
        color: gray;
        font-size: 13px;
        margin: 0 0 25px;
    }

    #cards {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .card {
        flex: 1;
        min-width: 200px;
        background-color: white;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        padding: 20px;
    }

    .card p {
        color: gray;
        font-size: 13px;
        margin: 0 0 8px;
    }

    .card h2 {
        margin: 0;
        font-size: 28px;
    }

    .card .sub {
        color: green;
        font-size: 12px;
        margin-top: 8px;
    }

    #mapSection {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: stretch;
    }

    #mapCard {
        flex: 2;
        min-width: 300px;
        background-color: white;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        padding: 20px;
    }

    #mapCard > p {
        color: gray;
        font-size: 12px;
        font-weight: bold;
        margin: 0 0 8px;
    }

    #detailsCard {
        flex: 1;
        min-width: 250px;
        background-color: white;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        padding: 20px;
        box-sizing: border-box;
        overflow-y: auto;
    }

    #detailsCard > p {
        color: gray;
        font-size: 12px;
        font-weight: bold;
        margin: 0 0 8px;
    }

    #searchRow {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 150px;
    }

    .search-wrap input {
        width: 100%;
        height: 38px;
        border: 1px solid #ddd;
        border-radius: 7px;
        padding: 0 10px;
        box-sizing: border-box;
        font-family: Arial;
        font-size: 13px;
    }

    #searchResults {
        display: none;
        position: absolute;
        top: 42px;
        left: 0;
        right: 0;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 7px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        max-height: 220px;
        overflow-y: auto;
        z-index: 1000;
    }

    #searchResults div {
        padding: 10px 12px;
        font-size: 13px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
    }

    #searchResults div:last-child {
        border-bottom: none;
    }

    #searchResults div:hover {
        background-color: whitesmoke;
    }

    #searchRow button {
        height: 38px;
        padding: 0 15px;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        background-color: blue;
        color: white;
        white-space: nowrap;
    }

    #currentLocationBtn {
        background-color: white;
        color: blue;
        border: 1px solid blue;
    }

    #map {
        height: 400px;
        border-radius: 10px;
    }

    .red-marker {
        background-color: red;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        border: 2px solid white;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
    }

    #eventDetails h3 {
        margin: 10px 0 8px;
        font-size: 16px;
    }

    #eventDetails p {
        color: #444;
        font-size: 13px;
        line-height: 1.5;
    }

    #buyTicketBtn {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: blue;
        color: white;
        text-decoration: none;
        border-radius: 7px;
    }
</style>
</head>
<body>
<?php require("../../partials/client/header.php") ?>

<?php
require_once "../../models/client/eventInfo.php";

$uid=$_SESSION["uid"];
$myEventsCount=countEventsByUid($uid);
$myTicketsCount=countTicketsByUid($uid);
$reportStats=countReportsByUid($uid);
$events=getAllEvents();
?>

<div id="middle">
    <h1>Client Dashboard</h1>
    <p class="subtitle">Overview of your activity and nearby events</p>

    <div id="cards">
        <div class="card">
            <p>My Events</p>
            <h2><?php echo $myEventsCount; ?></h2>
        </div>

        <div class="card">
            <p>Tickets Bought</p>
            <h2><?php echo $myTicketsCount; ?></h2>
        </div>

        <div class="card">
            <p>Reports</p>
            <h2><?php echo $reportStats["total"]; ?></h2>
            <div class="sub"><?php echo $reportStats["resolved"]; ?> resolved</div>
        </div>
    </div>

    <h2>Nearby Events Map</h2>

    <div id="mapSection">
        <div id="mapCard">
            <p>Search Location</p>

            <div id="searchRow">
                <div class="search-wrap">
                    <input type="text" id="searchInput" placeholder="Search place or event area" autocomplete="off">
                    <div id="searchResults"></div>
                </div>
                <button type="button" id="searchBtn">Search</button>
                <button type="button" id="currentLocationBtn">Current Location</button>
            </div>

            <div id="map"></div>
        </div>

        <div id="detailsCard">
            <p>Event Details</p>

            <div id="eventDetails">
                <p id="detailsPlaceholder">Click a marker on the map to see event details</p>
                <h3 id="detailsTitle" style="display:none;"></h3>
                <p id="detailsDescription" style="display:none;"></p>
                <a id="buyTicketBtn" href="#" style="display:none;">Buy Ticket</a>
            </div>
        </div>
    </div>
</div>

<script>
    const eventsData = <?php echo json_encode($events); ?>;
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="../../js/client/dashboard.js" defer></script>

<?php require("../../partials/client/header-end.php") ?>
