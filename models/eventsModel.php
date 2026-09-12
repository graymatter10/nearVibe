<?php
require_once("../../models/dbConnect.php");
function getEvents($uid=0, $public=false)
{
    $conn=dbConnection();
    $sql="SELECT * FROM events WHERE (?=0 OR uid=?)";
    $sql.=" ORDER BY eid DESC";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"ii",$uid,$uid);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $rows=[];
    while($row=mysqli_fetch_assoc($result))
    {
        $row['status']='AVAILABLE'; // Display label; the schema has no event status.
        $rows[]=$row;
    }
    return $rows;
}
function getEvent($eid)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"SELECT * FROM events WHERE eid=?");
    mysqli_stmt_bind_param($stmt,"i",$eid);
    mysqli_stmt_execute($stmt);
    $row=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if($row) { $row['status']='AVAILABLE'; }
    return $row;
}
function saveEvent($eid,$uid,$title,$description,$price,$lat,$lng,$type)
{
    $conn=dbConnection();
    if ($eid==0)
    {
        $stmt=mysqli_prepare($conn,"INSERT INTO events (uid,title,description,tprice,latitude,longitude,type) VALUES (?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt,"issidds",$uid,$title,$description,$price,$lat,$lng,$type);
    }
    else
    {
        $stmt=mysqli_prepare($conn,"UPDATE events SET title=?,description=?,tprice=?,latitude=?,longitude=? WHERE eid=? AND uid=?");
        mysqli_stmt_bind_param($stmt,"ssiddii",$title,$description,$price,$lat,$lng,$eid,$uid);
    }
    return mysqli_stmt_execute($stmt);
}
function deleteEvent($eid,$uid,$admin=false)
{
    $conn=dbConnection();
     
    $stmt=mysqli_prepare($conn,"DELETE FROM events WHERE eid=? AND (uid=? OR ?=1) AND NOT EXISTS (SELECT 1 FROM ticket WHERE eid=?) AND NOT EXISTS (SELECT 1 FROM reports WHERE eid=?) AND NOT EXISTS (SELECT 1 FROM promotion WHERE eid=?)");
    mysqli_stmt_bind_param($stmt,"iiiiii",$eid,$uid,$admin,$eid,$eid,$eid);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt)>0;
}
?>
