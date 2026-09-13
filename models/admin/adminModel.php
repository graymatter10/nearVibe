<?php
require_once("../../models/dbConnect.php");

function getUsers()
{
    $conn=dbConnection();

    $sql="SELECT uid,name,email,type FROM users ORDER BY uid";

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

    $sql="SELECT r.*,u.name,e.title,e.status AS event_status
          FROM reports r
          LEFT JOIN users u ON u.uid=r.uid
          LEFT JOIN events e ON e.eid=r.eid
          ORDER BY r.rid DESC";

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

    $sql="SELECT COUNT(*) AS total,
                 COALESCE(SUM(status='ACTIVE'),0) AS active,
                 COALESCE(SUM(status='RESOLVED'),0) AS resolved
          FROM reports";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

function getAdminEvents()
{
    $conn=dbConnection();

    $sql="SELECT * FROM events ORDER BY eid DESC";

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

function validAdmin($adminUid)
{
    $conn=dbConnection();

    $sql="SELECT users.uid
          FROM users
          INNER JOIN admin ON admin.aid=users.uid
          WHERE users.uid=? AND users.type='ADMIN'";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$adminUid);
    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($result)>0;
}

function closeEventAsAdmin($eid,$adminUid)
{
    if(!validAdmin($adminUid))
    {
        return false;
    }

    $conn=dbConnection();

    $sql="UPDATE events
          SET status='CLOSED'
          WHERE eid=? AND status='ACTIVE'";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt)>0;
}

function deleteEventAsAdmin($eid,$adminUid)
{
    if(!validAdmin($adminUid))
    {
        return false;
    }

    $conn=dbConnection();

    mysqli_begin_transaction($conn);

    try
    {
        $stmt=mysqli_prepare(
            $conn,
            "DELETE payment
             FROM payment
             INNER JOIN ticket ON payment.tid=ticket.tid
             WHERE ticket.eid=?"
        );

        mysqli_stmt_bind_param($stmt,"i",$eid);
        mysqli_stmt_execute($stmt);


        $stmt=mysqli_prepare(
            $conn,
            "DELETE FROM ticket WHERE eid=?"
        );

        mysqli_stmt_bind_param($stmt,"i",$eid);
        mysqli_stmt_execute($stmt);


        $stmt=mysqli_prepare(
            $conn,
            "DELETE FROM reports WHERE eid=?"
        );

        mysqli_stmt_bind_param($stmt,"i",$eid);
        mysqli_stmt_execute($stmt);


        $stmt=mysqli_prepare(
            $conn,
            "DELETE FROM promotion WHERE eid=?"
        );

        mysqli_stmt_bind_param($stmt,"i",$eid);
        mysqli_stmt_execute($stmt);


        $stmt=mysqli_prepare(
            $conn,
            "DELETE FROM events WHERE eid=?"
        );

        mysqli_stmt_bind_param($stmt,"i",$eid);
        mysqli_stmt_execute($stmt);


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

function closeReportedEvent($eid,$adminUid)
{
    return closeEventAsAdmin($eid,$adminUid);
}

function closeEventFromReport($rid,$adminUid)
{
    $conn=dbConnection();

    $stmt=mysqli_prepare(
        $conn,
        "SELECT eid FROM reports WHERE rid=?"
    );

    mysqli_stmt_bind_param($stmt,"i",$rid);
    mysqli_stmt_execute($stmt);

    $report=mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if(!$report)
    {
        return false;
    }

    return closeEventAsAdmin(
        (int)$report['eid'],
        $adminUid
    );
}
?>