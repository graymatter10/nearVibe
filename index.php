<?php

require_once __DIR__ . "/controllers/guestOnly.php";
require_once __DIR__ . "/models/client/eventInfo.php";

$events = getAllEvents();

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>NearVibe</title>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    min-height: 100vh;
    background: #f5f7fb;
}

.top-header {
    width: 100%;
    height: 70px;

    background: white;

    display: flex;
    align-items: center;

    padding: 0 40px;

    border-bottom: 1px solid #e5e7eb;

    position: fixed;
    top: 0;
    left: 0;

    z-index: 1000;
}

.header-logo {
    font-size: 22px;
    font-weight: bold;
    color: #2563eb;

    width: 180px;
}

.header-title {
    font-size: 16px;
    font-weight: bold;
    color: #111827;
}

.header-login-btn {
    margin-left: auto;

    background: #2563eb;
    color: white;

    padding: 10px 24px;

    border-radius: 8px;

    font-size: 14px;
    font-weight: bold;

    text-decoration: none;
}

.page-content {
    padding: 110px 40px 40px 40px;
}

.page-content h2 {
    font-size: 18px;
    margin: 0 0 15px;
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
    height: 500px;
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

@media (max-width: 700px) {

    .header-title {
        display: none;
    }

    .page-content {
        padding: 100px 20px 30px 20px;
    }

    #map {
        height: 350px;
    }

}

</style>

</head>

<body>

<header class="top-header">

    <div class="header-logo">
        NearVibe
    </div>

    <div class="header-title">
        Discover Events Near You
    </div>

    <a class="header-login-btn" href="login.php">
        Login
    </a>

</header>

<div class="page-content">

    <h2>Nearby Events</h2>

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
            </div>

        </div>

    </div>

</div>

<script>
    const eventsData = <?php echo json_encode($events); ?>;
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="js/index.js" defer></script>

</body>
</html>
