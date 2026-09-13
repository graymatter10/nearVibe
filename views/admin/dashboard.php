<?php require_once __DIR__ . "/../../controllers/admin/sessionManage.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/admin/head.php") ?>
<?php require("../../partials/dashboardStyle.php") ?>
<style>
    #middle {
        flex: 1;
        min-width: 0;
        padding: 20px;
    }
</style>
</head>
<body>
<?php require("../../partials/admin/header.php") ?>

<?php
require_once "../../models/admin/adminModel.php";

$events=getAdminEvents();
?>

<div id="middle">
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
            </div>
        </div>
    </div>
</div>

<script>
    const eventsData = <?php echo json_encode($events); ?>;
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="../../js/index.js" defer></script>

<?php require("../../partials/admin/header-end.php") ?>

</body>
</html>
