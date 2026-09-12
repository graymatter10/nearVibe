<?php require_once __DIR__ . "/../../controllers/client/sessionManage.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/client/head.php") ?>
<?php require("../../partials/dashboardStyle.php") ?>
</head>
<body>
<?php require("../../partials/client/header.php") ?>

<?php
require_once "../../models/client/eventInfo.php";

$uid=$_SESSION["uid"];
$reportStats=countReportsByUid($uid);

$dashboardTitle="Client Dashboard";
$dashboardSubtitle="Overview of your activity and nearby events";
$statCards=[
    ["label"=>"My Events", "value"=>countEventsByUid($uid)],
    ["label"=>"Tickets Bought", "value"=>countTicketsByUid($uid)],
    ["label"=>"Reports", "value"=>$reportStats["total"], "sub"=>$reportStats["resolved"]." resolved"]
];
$events=getAllEvents();
$canBuyTicket=true;
?>

<?php require("../../partials/dashboardBody.php") ?>

<?php require("../../partials/client/header-end.php") ?>
