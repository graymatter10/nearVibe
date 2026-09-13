<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/eventsModel.php");
require_once("../../models/client/reportModel.php");
if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $eid=(int)$_POST['eid'];
    $description=trim($_POST['description']);
    if (!getEvent($eid) || $description=='' || strlen($description)>200)
    {
        $message="Select an event and enter up to 200 characters.";
    }
    else
    {
        addReport($eid,$_SESSION['uid'],$description);
        $message="Report submitted.";
    }
}
$events=getEvents(0,true);
?>
