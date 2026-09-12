<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
require_once("../../models/corporate/salesModel.php");

$events=getSales($_SESSION['uid']);

$totalTickets=0;
$totalRevenue=0;
$totalEventsWithSales=0;
$bestEvent="No sales yet";
$highestRevenueEvent="No sales yet";
$bestTicketCount=0;
$highestRevenue=0;
$currentSalesStatus="No sales yet";

foreach($events as $event)
{
    $totalTickets+=(int)$event['tickets'];
    $totalRevenue+=(int)$event['revenue'];

    if((int)$event['tickets']>0)
    {
        $totalEventsWithSales++;
        $currentSalesStatus="Active";
    }

    if((int)$event['tickets']>$bestTicketCount)
    {
        $bestTicketCount=(int)$event['tickets'];
        $bestEvent=$event['title'];
    }

    if((int)$event['revenue']>$highestRevenue)
    {
        $highestRevenue=(int)$event['revenue'];
        $highestRevenueEvent=$event['title'];
    }
}

$averagePrice=0;
if($totalTickets>0)
{
    $averagePrice=round($totalRevenue/$totalTickets);
}

$salesSummary=[
    'totalTickets'=>$totalTickets,
    'totalRevenue'=>$totalRevenue,
    'averagePrice'=>$averagePrice,
    'bestEvent'=>$bestEvent,
    'highestRevenueEvent'=>$highestRevenueEvent,
    'totalEvents'=>$totalEventsWithSales,
    'paidTickets'=>$totalTickets,
    'status'=>$currentSalesStatus
];
?>
