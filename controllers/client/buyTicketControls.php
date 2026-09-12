<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/eventsModel.php");
if(isset($_GET['id']))
{
    $selectedEvent=getEvent((int)$_GET['id']);
    if($selectedEvent && $selectedEvent['type']=='CORPORATE')
    {
        header("Location: payment.php?eid=".(int)$selectedEvent['eid']);
        exit();
    }
    $message="Tickets can only be purchased for corporate events. Choose an event below.";
}

$allEvents=getEvents(0,true);
$events=[];
foreach($allEvents as $event)
{
    if(isset($event['type']) && $event['type']=='CORPORATE')
    {
        $events[]=$event;
    }
}
?>
