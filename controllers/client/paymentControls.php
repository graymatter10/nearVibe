<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/eventsModel.php");
require_once("../../models/client/paymentModel.php");
$eid=(int)($_GET['eid'] ?? 0);
$event=getEvent($eid);
if (!$event || $event['type']!='CORPORATE')
{
    die("Event is not available. Go back to Buy Ticket.");
}
function validCardNumber($number)
{
    if(!preg_match('/^[0-9]{13,19}$/',$number))
    {
        return false;
    }

    $sum=0;
    $double=false;

    for($i=strlen($number)-1;$i>=0;$i--)
    {
        $digit=(int)$number[$i];
        if($double)
        {
            $digit=$digit*2;
            if($digit>9)
            {
                $digit=$digit-9;
            }
        }
        $sum=$sum+$digit;
        $double=!$double;
    }

    return $sum%10==0;
}

$mobileError='';
$cardError='';
$methodError='';
$paymentError='';

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $method=$_POST['method'] ?? '';
    $mobileNumber=trim($_POST['mobileNumber'] ?? '');
    $cardNumber=str_replace(' ','',trim($_POST['cardNumber'] ?? ''));

    if (!in_array($method,['BKASH','CARD']))
    {
        $methodError="Choose BKASH or CARD.";
    }
    elseif ($method=='BKASH' && !preg_match('/^01[3-9][0-9]{8}$/',$mobileNumber))
    {
        $mobileError="Enter a valid bKash number.";
    }
    elseif ($method=='CARD' && !validCardNumber($cardNumber))
    {
        $cardError="Enter a valid card number.";
    }
    elseif (!isset($_SESSION['checkout']) || !hash_equals($_SESSION['checkout'],$_POST['checkout'] ?? ''))
    {
        $paymentError="Order already submitted. Open Buy Ticket again.";
    }
    else
    {
        $number=$method=='BKASH' ? $mobileNumber : $cardNumber;
        $tid=buyTicket($_SESSION['uid'],$eid,$method,$number);
        if ($tid)
        {
            unset($_SESSION['checkout']);
            header("Location: paymentSuccess.php?tid=".$tid);
            exit();
        }
        $paymentError="Payment could not be saved.";
    }
}
if (!isset($_SESSION['checkout']))
{
    $_SESSION['checkout']=bin2hex(random_bytes(16));
}
?>
