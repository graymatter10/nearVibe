<?php

if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}

require_once("../../models/admin/adminModel.php");

markReportedEvents();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $rid=$_POST["rid"];
    $action=$_POST["action"];

    if($action=="resolve")
    {
        if(resolveReport($rid))
        {
            $message="Report removed and event activated.";
        }
        else
        {
            $message="Report could not be resolved.";
        }
    }
    else if($action=="close")
    {
        if(deleteEventFromReport($rid,$_SESSION["uid"]))
        {
            $message="Reported event deleted successfully.";
        }
        else
        {
            $message="Reported event could not be deleted.";
        }
    }
}

$reports=getReports();
$summary=reportSummary();

?>