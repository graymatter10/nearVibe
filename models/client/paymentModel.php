<?php
require_once("../../models/dbConnect.php");

function buyTicket($uid,$eid,$method,$number)
{
    if(!in_array($method,['BKASH','CARD'],true)) { return false; }
    // Retain the bKash number; keep only the last four card digits.
    $number=$method=='CARD' ? '****'.substr($number,-4) : $number;
    $conn=dbConnection();
    mysqli_begin_transaction($conn);
    try
    {
        $stmt=mysqli_prepare($conn,"SELECT eid FROM events WHERE eid=? AND type='CORPORATE' FOR UPDATE");
        mysqli_stmt_bind_param($stmt,"i",$eid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception("Event lookup failed."); }
        if(mysqli_num_rows(mysqli_stmt_get_result($stmt))==0)
        {
            mysqli_rollback($conn);
            return false;
        }

        $stmt=mysqli_prepare($conn,"INSERT INTO ticket (uid,eid) VALUES (?,?)");
        mysqli_stmt_bind_param($stmt,"ii",$uid,$eid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception("Ticket could not be saved."); }
        $tid=mysqli_insert_id($conn);

        $stmt=mysqli_prepare($conn,"INSERT INTO payment (tid,uid,method,number) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($stmt,"iiss",$tid,$uid,$method,$number);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception("Payment could not be saved."); }
        if(!mysqli_commit($conn)) { throw new Exception("Payment could not be committed."); }
        return $tid;
    }
    catch(Exception $error)
    {
        mysqli_rollback($conn);
        return false;
    }
}

function getTicket($tid,$uid)
{
    $conn=dbConnection();
    $sql="SELECT t.tid,e.title,p.method,p.number FROM ticket t JOIN events e ON e.eid=t.eid JOIN payment p ON p.tid=t.tid AND p.uid=t.uid WHERE t.tid=? AND t.uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"ii",$tid,$uid);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
?>
