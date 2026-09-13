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
    $eid=$_POST["eid"];
    $action=$_POST["action"];

    if($action=="delete")
    {
        if(deleteEventAsAdmin($eid,$_SESSION["uid"]))
        {
            $message="Event deleted successfully.";
        }
        else
        {
            $message="Event could not be deleted.";
        }
    }
}

$events=getAdminEvents();

?>