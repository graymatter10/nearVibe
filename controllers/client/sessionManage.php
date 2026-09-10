<?php
    session_start();

    require_once __DIR__ . "/../../models/userControl.php";

    if(getUserType() != "CLIENT"){
        header("Location: ../../index.php");
        exit;
    }
?>