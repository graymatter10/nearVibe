<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/eventsModel.php");
$eid=(int)($_GET['eid'] ?? 0);
$event=['title'=>'','description'=>'','tprice'=>'','latitude'=>'','longitude'=>''];
if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_SESSION['corporateEventCreated']))
{
    $message=$_SESSION['corporateEventCreated'];
    unset($_SESSION['corporateEventCreated']);
}

if ($eid)
{
    $event=getEvent($eid);
    if (!$event || $event['uid']!=$_SESSION['uid'])
    {
        http_response_code(403);
        die("Access denied.");
    }
}
if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $title=trim($_POST['title']);
    $description=trim($_POST['description']);
    $priceText=trim($_POST['tprice'] ?? '');
    $price=$priceText==='' ? false : filter_var($priceText,FILTER_VALIDATE_INT);
    $lat=filter_var($_POST['latitude'],FILTER_VALIDATE_FLOAT);
    $lng=filter_var($_POST['longitude'],FILTER_VALIDATE_FLOAT);
    if ($title=='' || strlen($title)>100 || strlen($description)>1000 || $price===false || $price<0 || $price>2147483647 || $lat===false || abs($lat)>90 || $lng===false || abs($lng)>180)
    {
        $message="Please enter valid event details and coordinates.";
    }
    else
    {
        if(saveEvent($eid,$_SESSION['uid'],$title,$description,$price,$lat,$lng,"CORPORATE"))
        {
            if($eid==0)
            {
                $_SESSION['corporateEventCreated']="Event created successfully.";
                header("Location: createEvent.php");
            }
            else
            {
                header("Location: manageEvent.php");
            }
            exit();
        }
        else
        {
            $message="Event could not be saved. Please try again.";
        }
    }
}
?>
