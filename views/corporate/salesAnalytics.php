<?php
require_once("../../controllers/corporate/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
require("../../controllers/corporate/salesAnalyticsControls.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/corporate/head.php") ?>
<style>
            #middle {
                padding: 25px 30px;
                flex: 1;
                min-width: 0;
            }

            #middle h2 {
                margin: 0 0 8px;
            }

            #intro {
                color: gray;
                font-size: 13px;
                margin: 0 0 25px;
            }

            #cards {
                display: flex;
                gap: 20px;
                margin-bottom: 25px;
            }

            .card {
                flex: 1;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 18px;
                p {
                    color: gray;
                    font-size: 13px;
                    margin: 0 0 8px;
                }
                h2 {
                    color: black;
                }
                .growth {
                    color: green;
                    font-size: 12px;
                    margin: 0;
                }
            }

            #summary {
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 25px;
                h4 {
                    margin: 0 0 15px;
                }
                p {
                    font-size: 13px;
                    margin: 0 0 15px;
                }
            }

            #summaryRow {
                display: flex;
                gap: 20px;
            }

            .column {
                flex: 1;
            }

            #eventTable {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                border: 1px solid #ddd;
                th {
                    background-color: aliceblue;
                    color: gray;
                    font-size: 12px;
                    text-align: left;
                    padding: 13px 10px;
                }
                td {
                    padding: 15px 10px;
                    border-bottom: 1px solid #ddd;
                    font-size: 12px;
                }
            }

            #note {
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 18px;
                margin-top: 20px;
                color: gray;
                font-size: 12px;
            }
        
</style>
</head>
<body>
<?php require("../../partials/corporate/header.php") ?>
<div id="middle">
            <h2>Sales Analytics</h2>
            <p id="intro">Ticket sales and revenue overview | <span id="liveStatus" role="status">Live updates on</span></p>
            <div id="cards">
                <div class="card">
                    <p>Total Tickets Sold</p>
                    <h2>
                        <?php echo $salesSummary["totalTickets"]; ?>
                    </h2>
                    <p class="growth">Paid ticket records</p>
                </div>
                <div class="card">
                    <p>Total Revenue</p>
                    <h2>BDT <?php echo $salesSummary["totalRevenue"]; ?>
                    </h2>
                    <p class="growth">From successful payments</p>
                </div>
                <div class="card">
                    <p>Average Ticket Price</p>
                    <h2>BDT <?php echo $salesSummary["averagePrice"]; ?>
                    </h2>
                    <p class="growth">Average paid ticket value</p>
                </div>
            </div>
            <div id="summary">
                <h4>Overall Sales Summary</h4>
                <div id="summaryRow">
                    <div class="column">
                        <p>Best selling event: <?php echo h($salesSummary["bestEvent"]); ?>
                        </p>
                        <p>Highest revenue event: <?php echo h($salesSummary["highestRevenueEvent"]); ?>
                        </p>
                        <p>Total corporate events with ticket sales: <?php echo $salesSummary["totalEvents"]; ?>
                        </p>
                    </div>
                    <div class="column">
                        <p>Paid tickets: <?php echo $salesSummary["paidTickets"]; ?>
                        </p>
                        <p>Total revenue collected: BDT <?php echo $salesSummary["totalRevenue"]; ?>
                        </p>
                        <p>Current sales status: <?php echo h($salesSummary["status"]); ?>
                        </p>
                    </div>
                </div>
            </div>
            <h4>Event Sales Details</h4>
            <table id="eventTable">
                <tr>
                    <th>Event Name</th>
                    <th>Tickets Sold</th>
                    <th>Revenue</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($events as $event) { ?>
                <tr>
                    <td>
                        <?php echo h($event["title"]); ?>
                    </td>
                    <td>
                        <?php echo $event["tickets"]; ?>
                    </td>
                    <td>BDT <?php echo $event["revenue"]; ?>
                    </td>
                    <td>
                        <?php echo h($event["status"]); ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <script src="../../js/salesLive.js"></script>
<?php require("../../partials/corporate/header-end.php") ?>

</body>
</html>