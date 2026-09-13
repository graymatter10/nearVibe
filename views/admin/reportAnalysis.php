<?php
require_once("../../controllers/admin/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/admin/reportAnalysisControls.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/admin/head.php") ?>
<style>
            #middle {
                padding: 25px 30px;
                flex: 1;
                min-width: 0;
            }

            #top {
                margin-bottom: 25px;
            }

            #top h2 {
                margin: 0 0 8px;
            }

            #top p {
                margin: 0;
                color: gray;
                font-size: 13px;
            }

            #cards {
                display: flex;
                gap: 20px;
                margin-bottom: 30px;
            }

            .card {
                flex: 1;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 20px;
            }

            .card p {
                color: gray;
                font-size: 13px;
                margin: 0 0 8px;
            }

            .card h2 {
                margin: 0 0 15px;
            }

            #reportTable {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                border: 1px solid #ddd;
            }

            #reportTable th {
                background-color: whitesmoke;
                color: gray;
                font-size: 12px;
                text-align: left;
                padding: 13px 10px;
            }

            #reportTable td {
                padding: 15px 10px;
                border-bottom: 1px solid #ddd;
                font-size: 12px;
            }

            #actions {
                margin-top: 6px;
                font-size: 12px;
                color: blue;
            }

            #actions button {
                background-color: transparent;
                color: blue;
                border: none;
                padding: 0;
                font-size: 12px;
                cursor: pointer;
            }
        
</style>
</head>
<body>
<?php require("../../partials/admin/header.php") ?>
<div id="middle">
            <?php if(isset($message)) { echo '<p>'.h($message).'</p>'; } ?>
            <div id="top">
                <h2>Report Analysis</h2>
                <p>Review reports submitted by users and take action</p>
            </div>
            <div id="cards">
                <div class="card">
                    <p>Total Reports</p>
                    <h2>
                        <?php echo $summary['total']; ?>
                    </h2>
                </div>
                <div class="card">
                    <p>Active</p>
                    <h2>
                        <?php echo $summary['active']; ?>
                    </h2>
                </div>
                <div class="card">
                    <p>Resolved</p>
                    <h2>
                        <?php echo $summary['resolved']; ?>
                    </h2>
                </div>
            </div>
            <table id="reportTable">
                <tr>
                    <th>Report ID</th>
                    <th>Event</th>
                    <th>Reported By</th>
                    <th>Details</th>
                    <th>Report Status</th>
                    <th>Event Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($reports as $report) { ?>
                <tr>
                    <td>
                        <?php echo $report['rid']; ?>
                    </td>
                    <td>
                        <?php echo h($report['title']); ?>
                    </td>
                    <td>
                        <?php echo h($report['name']); ?>
                    </td>
                    <td>
                        <?php echo h($report['description']); ?>
                    </td>
                    <td>
                        <?php echo h($report['status']); ?>
                    </td>
                    <td>
                        <?php echo h($report['event_status']); ?>
                    </td>
                    <td>
                        <div id="actions">
                            <form method="POST">
                                <?php formToken(); ?>
                                <input type="hidden" name="rid" value="<?php echo $report['rid']; ?>">
                                <button name="action" value="resolve" type="submit">Resolve</button> | <button name="action" value="close" type="submit">Close Event</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
<?php require("../../partials/admin/header-end.php") ?>

</body>
</html>