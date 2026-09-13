<?php

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION["uid"])) {

        require_once __DIR__ . "/../models/userControl.php";

        $type = getUserType();

        if ($type == "CLIENT") {
            header("Location: views/client/dashboard.php");
            exit;
        } elseif ($type == "CORPORATE") {
            header("Location: views/corporate/dashboard.php");
            exit;
        } elseif ($type == "ADMIN") {
            header("Location: views/admin/dashboard.php");
            exit;
        }
    }

?>
