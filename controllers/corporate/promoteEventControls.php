<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/eventsModel.php");
require_once("../../models/corporate/promotionModel.php");
if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $eid=(int)$_POST['eid'];
    $event=getEvent($eid);
    $amount=filter_var($_POST['amount'],FILTER_VALIDATE_INT);
    $duration=filter_var($_POST['duration'],FILTER_VALIDATE_INT);
    if (!$event || $event['uid']!=$_SESSION['uid'] || $event['type']!='CORPORATE' || $amount===false || $amount<1 || $amount>2147483647 || $duration===false || $duration<1 || $duration>2147483647)
    {
        $message="Choose your corporate event and positive whole numbers.";
    }
    else
    {
        addPromotion($_SESSION['uid'],$amount,$duration,$eid);
        $message="Promotion saved.";
    }
}
$events=getEvents($_SESSION['uid'],true);
?>
