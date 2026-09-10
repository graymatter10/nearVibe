    <div id="heading">
        <a href="http://localhost/Final" style="text-decoration: none;"><h2 id="logo">NearVibe</h2></a>
        
        <h4 id="client">Client</h4>
    </div>

    <div id="layout">

        <div id="menu">
            <a href="../../views/client/dashboard.php">
                <?php if(basename($_SERVER["PHP_SELF"]) == "dashboard.php"){ ?>
                    <button id="db" class="active">Dashboard</button>
                <?php } else { ?>
                    <button id="db">Dashboard</button>
                <?php } ?>
            </a>

            <a href="../../views/client/createEvent.php">
                <?php if(basename($_SERVER["PHP_SELF"]) == "createEvent.php"){ ?>
                    <button id="ce" class="active">Create Event</button>
                <?php } else { ?>
                    <button id="ce">Create Event</button>
                <?php } ?>
            </a>

            <a href="../../views/client/manageEvents.php">
                <?php if(basename($_SERVER["PHP_SELF"]) == "manageEvents.php"){ ?>
                    <button id="me" class="active">Manage Events</button>
                <?php } else { ?>
                    <button id="me">Manage Events</button>
                <?php } ?>
            </a>

            <a href="../../views/client/buyTicket.php">
                <?php if(basename($_SERVER["PHP_SELF"]) == "buyTicket.php"){ ?>
                    <button id="bt" class="active">Buy Ticket</button>
                <?php } else { ?>
                    <button id="bt">Buy Ticket</button>
                <?php } ?>
            </a>

            <a href="../../views/client/report.php">
                <?php if(basename($_SERVER["PHP_SELF"]) == "report.php"){ ?>
                    <button id="re" class="active">Report</button>
                <?php } else { ?>
                    <button id="re">Report</button>
                <?php } ?>
            </a>

            <a href="../../views/client/accountSettings.php">
                <?php if(basename($_SERVER["PHP_SELF"]) == "accountSettings.php"){ ?>
                    <button id="as" class="active">Account Settings</button>
                <?php } else { ?>
                    <button id="as">Account Settings</button>
                <?php } ?>
            </a>

            <a href="../../index.php"><button id="db">Logout</button></a>
        </div>