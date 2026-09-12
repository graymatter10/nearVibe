<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/eventsModel.php");
if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $eid=(int)$_POST['eid'];
    if ($_POST['action']=='delete')
    {
        if(deleteEvent($eid,$_SESSION['uid'],false))
        {
            $message="Event deleted.";
        }
        else
        {
            $message="Cannot delete: event has tickets, reports or promotions.";
        }
    }
}
$events=getEvents($_SESSION['uid']);
?>
