<?php
require_once("../../models/dbConnect.php");
function addReport($eid, $uid, $description)
{
    $conn=dbConnection();
    $sql="INSERT INTO reports (eid,uid,status,description) VALUES (?,?,'ACTIVE',?)";
    $stmt=mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $eid, $uid, $description);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt)>0;
}
?>
