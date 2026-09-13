<?php
require_once("../../models/dbConnect.php");

function getSales($uid)
{
    $conn=dbConnection();

    $sql="SELECT e.eid,e.title,e.tprice,'AVAILABLE' AS status,
          COUNT(p.pid) AS tickets,
          (COUNT(p.pid) * e.tprice) AS revenue
          FROM events e
          LEFT JOIN ticket t ON t.eid=e.eid
          LEFT JOIN payment p ON p.tid=t.tid
          WHERE e.uid=? AND e.type='CORPORATE'
          GROUP BY e.eid,e.title,e.tprice
          ORDER BY e.eid DESC";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);

    $rows=[];
    while($row=mysqli_fetch_assoc($result))
    {
        $row['tickets']=(int)$row['tickets'];
        $row['revenue']=(int)$row['revenue'];
        $rows[]=$row;
    }
    return $rows;
}
?>
