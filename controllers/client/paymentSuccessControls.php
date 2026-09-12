<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/client/paymentModel.php");
$tid=(int)($_GET['tid'] ?? 0);
$ticket=getTicket($tid,$_SESSION['uid']);
if (!$ticket)
{
    http_response_code(404);
    die("Ticket not found.");
}
?>
