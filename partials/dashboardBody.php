<div id="middle">
    <h1><?php echo $dashboardTitle; ?></h1>
    <p class="subtitle"><?php echo $dashboardSubtitle; ?></p>

    <div id="cards">
        <?php foreach($statCards as $card){ ?>
            <div class="card">
                <p><?php echo $card["label"]; ?></p>
                <h2><?php echo $card["value"]; ?></h2>
                <?php if(isset($card["sub"])){ ?>
                    <div class="sub"><?php echo $card["sub"]; ?></div>
                <?php } ?>
            </div>
        <?php } ?>
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
    const canBuyTicket = <?php echo json_encode($canBuyTicket); ?>;
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="../../js/dashboard.js" defer></script>
