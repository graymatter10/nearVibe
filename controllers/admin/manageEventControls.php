<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}

require_once("../../models/admin/adminModel.php");

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $eid=(int)($_POST['eid'] ?? 0);
    $action=$_POST['action'] ?? '';

    if($action=='close')
    {
        if(closeEventAsAdmin($eid,$_SESSION['uid']))
        {
            $message="Event closed successfully.";
        }
        else
        {
            $message="Event is already closed or could not be closed.";
        }
    }

    if($action=='delete')
    {
        if(deleteEventAsAdmin($eid,$_SESSION['uid']))
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