<?php
require_once("../../models/dbConnect.php");
function addPromotion($uid, $amount, $duration, $eid)
{
    $conn=dbConnection();
    $sql="INSERT INTO promotion (uid,amount,duration,eid) VALUES (?,?,?,?)";
    $stmt=mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $uid, $amount, $duration, $eid);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt)>0;
}
?>
