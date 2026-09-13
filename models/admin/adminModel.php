<?php
require_once("../../models/dbConnect.php");

function getUsers()
{
    $conn=dbConnection();
    $sql="SELECT uid,name,email,phone,type FROM users ORDER BY uid";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $rows=[];

    while($row=mysqli_fetch_assoc($result))
    {
        $rows[]=$row;
    }

    return $rows;
}

function getAdminUser($uid)
{
    $conn=dbConnection();
    $sql="SELECT uid,name,email,phone,type FROM users WHERE uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function isAdminUser($adminUid)
{
    $conn=dbConnection();
    $sql="SELECT u.uid FROM users u INNER JOIN admin a ON a.aid=u.uid WHERE u.uid=? AND u.type='ADMIN'";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$adminUid);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result)>0;
}

function updateUserAsAdmin($uid,$name,$email,$phone,$adminUid)
{
    if(!isAdminUser($adminUid))
    {
        return false;
    }

    $conn=dbConnection();

    $check=mysqli_prepare($conn,"SELECT type FROM users WHERE uid=?");
    mysqli_stmt_bind_param($check,"i",$uid);
    mysqli_stmt_execute($check);
    $user=mysqli_fetch_assoc(mysqli_stmt_get_result($check));

    if(!$user || $user['type']=='ADMIN')
    {
        return false;
    }

    $emailCheck=mysqli_prepare($conn,"SELECT uid FROM users WHERE email=? AND uid<>?");
    mysqli_stmt_bind_param($emailCheck,"si",$email,$uid);
    mysqli_stmt_execute($emailCheck);

    if(mysqli_num_rows(mysqli_stmt_get_result($emailCheck))>0)
    {
        return false;
    }

    $sql="UPDATE users SET name=?,email=?,phone=? WHERE uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"sssi",$name,$email,$phone,$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        return false;
    }

    return true;
}

function deleteUserAsAdmin($uid,$adminUid)
{
    if(!isAdminUser($adminUid) || $uid==$adminUid)
    {
        return false;
    }

    $conn=dbConnection();

    $check=mysqli_prepare($conn,"SELECT type FROM users WHERE uid=?");
    mysqli_stmt_bind_param($check,"i",$uid);
    mysqli_stmt_execute($check);
    $user=mysqli_fetch_assoc(mysqli_stmt_get_result($check));

    if(!$user || $user['type']=='ADMIN')
    {
        return false;
    }

    mysqli_begin_transaction($conn);

    try
    {
        $stmt=mysqli_prepare($conn,"DELETE payment FROM payment INNER JOIN ticket ON payment.tid=ticket.tid INNER JOIN events ON ticket.eid=events.eid WHERE events.uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        $stmt=mysqli_prepare($conn,"DELETE FROM payment WHERE uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        $stmt=mysqli_prepare($conn,"DELETE payment FROM payment INNER JOIN ticket ON payment.tid=ticket.tid WHERE ticket.uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        $stmt=mysqli_prepare($conn,"DELETE ticket FROM ticket INNER JOIN events ON ticket.eid=events.eid WHERE events.uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        $stmt=mysqli_prepare($conn,"DELETE FROM ticket WHERE uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        $stmt=mysqli_prepare($conn,"DELETE reports FROM reports INNER JOIN events ON reports.eid=events.eid WHERE events.uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        $stmt=mysqli_prepare($conn,"DELETE FROM reports WHERE uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        $stmt=mysqli_prepare($conn,"DELETE promotion FROM promotion INNER JOIN events ON promotion.eid=events.eid WHERE events.uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        if($user['type']=='CORPORATE')
        {
            $stmt=mysqli_prepare($conn,"DELETE FROM promotion WHERE uid=?");
            mysqli_stmt_bind_param($stmt,"i",$uid);
            if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }
        }

        $stmt=mysqli_prepare($conn,"DELETE FROM events WHERE uid=?");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        if($user['type']=='CLIENT')
        {
            $stmt=mysqli_prepare($conn,"DELETE FROM client WHERE uid=?");
            mysqli_stmt_bind_param($stmt,"i",$uid);
            if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }
        }

        if($user['type']=='CORPORATE')
        {
            $stmt=mysqli_prepare($conn,"DELETE FROM corporate WHERE uid=?");
            mysqli_stmt_bind_param($stmt,"i",$uid);
            if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }
        }

        $stmt=mysqli_prepare($conn,"DELETE FROM users WHERE uid=? AND type<>'ADMIN'");
        mysqli_stmt_bind_param($stmt,"i",$uid);
        if(!mysqli_stmt_execute($stmt)) { throw new Exception(); }

        if(mysqli_stmt_affected_rows($stmt)>0)
        {
            mysqli_commit($conn);
            return true;
        }

        mysqli_rollback($conn);
        return false;
    }
    catch(Throwable $e)
    {
        mysqli_rollback($conn);
        return false;
    }
}

function resolveReport($rid)
{
    $conn=dbConnection();
    $sql="UPDATE reports SET status='RESOLVED' WHERE rid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$rid);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt)>0;
}

function getReports()
{
    $conn=dbConnection();
    $sql="SELECT r.*,u.name,e.title,CASE WHEN e.status='ACTIVE' THEN 'AVAILABLE' ELSE e.status END AS event_status FROM reports r LEFT JOIN users u ON u.uid=r.uid LEFT JOIN events e ON e.eid=r.eid ORDER BY r.rid DESC";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $rows=[];

    while($row=mysqli_fetch_assoc($result))
    {
        $rows[]=$row;
    }

    return $rows;
}

function reportSummary()
{
    $conn=dbConnection();
    $sql="SELECT COUNT(*) AS total,COALESCE(SUM(status='ACTIVE'),0) AS active,COALESCE(SUM(status='RESOLVED'),0) AS resolved FROM reports";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function closeEventAsAdmin($eid,$adminUid)
{
    if(!isAdminUser($adminUid))
    {
        return false;
    }

    $conn=dbConnection();
    $sql="UPDATE events SET status='CLOSED' WHERE eid=? AND status='ACTIVE'";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt)>0;
}

function closeReportedEvent($eid,$adminUid)
{
    return closeEventAsAdmin($eid,$adminUid);
}

function closeEventFromReport($rid,$adminUid)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"SELECT eid FROM reports WHERE rid=?");
    mysqli_stmt_bind_param($stmt,"i",$rid);
    mysqli_stmt_execute($stmt);
    $report=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if(!$report)
    {
        return false;
    }

    return closeEventAsAdmin((int)$report['eid'],$adminUid);
}

function deleteEventAsAdmin($eid,$adminUid)
{
    if(!isAdminUser($adminUid))
    {
        return false;
    }

    $conn=dbConnection();
    mysqli_begin_transaction($conn);

    $stmt=mysqli_prepare($conn,"DELETE payment FROM payment INNER JOIN ticket ON payment.tid=ticket.tid WHERE ticket.eid=?");
    mysqli_stmt_bind_param($stmt,"i",$eid);
    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $stmt=mysqli_prepare($conn,"DELETE FROM ticket WHERE eid=?");
    mysqli_stmt_bind_param($stmt,"i",$eid);
    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $stmt=mysqli_prepare($conn,"DELETE FROM reports WHERE eid=?");
    mysqli_stmt_bind_param($stmt,"i",$eid);
    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $stmt=mysqli_prepare($conn,"DELETE FROM promotion WHERE eid=?");
    mysqli_stmt_bind_param($stmt,"i",$eid);
    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $stmt=mysqli_prepare($conn,"DELETE FROM events WHERE eid=?");
    mysqli_stmt_bind_param($stmt,"i",$eid);
    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    if(mysqli_stmt_affected_rows($stmt)>0)
    {
        mysqli_commit($conn);
        return true;
    }

    mysqli_rollback($conn);
    return false;
}

function getAdminEvents()
{
    $conn=dbConnection();
    $sql="SELECT eid,uid,title,description,tprice,latitude,longitude,type,status FROM events ORDER BY eid DESC";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $rows=[];

    while($row=mysqli_fetch_assoc($result))
    {
        $rows[]=$row;
    }

    return $rows;
}
?>
