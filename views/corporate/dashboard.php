<?php require_once __DIR__ . "/../../controllers/corporate/sessionManage.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/corporate/head.php") ?>
<?php require("../../partials/dashboardStyle.php") ?>
</head>
<body>
<?php require("../../partials/corporate/header.php") ?>

<?php
require_once "../../models/corporate/eventInfo.php";

$uid=$_SESSION["uid"];

$dashboardTitle="Corporate Dashboard";
$dashboardSubtitle="Overview of your activity and nearby events";
$statCards=[
    ["label"=>"Corporate Events", "value"=>countEventsByUid($uid)],
    ["label"=>"Tickets Sold", "value"=>countTicketsSoldByOrganizer($uid)],
    ["label"=>"Revenue", "value"=>"BDT ".number_format(sumRevenueByOrganizer($uid))]
];
$events=getAllEvents();
$canBuyTicket=false;
?>

<?php require("../../partials/dashboardBody.php") ?>

<?php require("../../partials/corporate/header-end.php") ?>
