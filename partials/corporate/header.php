<?php    
    require_once __DIR__ . "/../../controllers/corporate/sessionManage.php";
?>


<div id="heading">
    <a href="../../views/corporate/dashboard.php" style="text-decoration: none;"><h2 id="logo">NearVibe</h2></a>

    <h4 id="corporate">Corporate</h4>
</div>

<div id="layout">

    <div id="menu">
        <a href="../../views/corporate/dashboard.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "dashboard.php"){ ?>
                <button id="db" class="active">Dashboard</button>
            <?php } else { ?>
                <button id="db">Dashboard</button>
            <?php } ?>
        </a>

        <a href="../../views/corporate/createEvent.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "createEvent.php"){ ?>
                <button id="ce" class="active">Create Event</button>
            <?php } else { ?>
                <button id="ce">Create Event</button>
            <?php } ?>
        </a>

        <a href="../../views/corporate/manageEvent.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "manageEvent.php"){ ?>
                <button id="me" class="active">Manage Events</button>
            <?php } else { ?>
                <button id="me">Manage Events</button>
            <?php } ?>
        </a>

        <a href="../../views/corporate/promoteEvent.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "promoteEvent.php"){ ?>
                <button id="pe" class="active">Promote Event</button>
            <?php } else { ?>
                <button id="pe">Promote Event</button>
            <?php } ?>
        </a>

        <a href="../../views/corporate/salesAnalytics.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "salesAnalytics.php"){ ?>
                <button id="sa" class="active">Sales Analytics</button>
            <?php } else { ?>
                <button id="sa">Sales Analytics</button>
            <?php } ?>
        </a>

        <a href="../../views/corporate/accountSettings.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "accountSettings.php"){ ?>
                <button id="as" class="active">Account Settings</button>
            <?php } else { ?>
                <button id="as">Account Settings</button>
            <?php } ?>
        </a>


        <form action="../../controllers/logout.php" method="post">
            <button id="db" type="submit">Logout</button>
        </form>

    </div>