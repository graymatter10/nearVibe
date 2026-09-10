<?php    
    require_once __DIR__ . "/../../controllers/admin/sessionManage.php";
?>


<div id="heading">
    <a href="../../views/admin/dashboard.php" style="text-decoration: none;"><h2 id="logo">NearVibe</h2></a>

    <h4 id="admin">Admin</h4>
</div>

<div id="layout">

    <div id="menu">
        <a href="../../views/admin/dashboard.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "dashboard.php"){ ?>
                <button id="db" class="active">Dashboard</button>
            <?php } else { ?>
                <button id="db">Dashboard</button>
            <?php } ?>
        </a>

        <a href="../../views/admin/manageUsers.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "manageUsers.php"){ ?>
                <button id="mu" class="active">Manage Users</button>
            <?php } else { ?>
                <button id="mu">Manage Users</button>
            <?php } ?>
        </a>

        <a href="../../views/admin/manageEvent.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "manageEvent.php"){ ?>
                <button id="me" class="active">Manage Events</button>
            <?php } else { ?>
                <button id="me">Manage Events</button>
            <?php } ?>
        </a>

        <a href="../../views/admin/reportAnalysis.php">
            <?php if(basename($_SERVER["PHP_SELF"]) == "reportAnalysis.php"){ ?>
                <button id="ra" class="active">Report Analysis</button>
            <?php } else { ?>
                <button id="ra">Report Analysis</button>
            <?php } ?>
        </a>

        <a href="../../views/admin/accountSettings.php">
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