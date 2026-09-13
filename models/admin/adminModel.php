<?php

require_once("../../models/dbConnect.php");

function getUsers()
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT uid,name,email,phone,type FROM users ORDER BY uid";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        $users=[];

        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $users[]=$row;
            }

            return $users;
        }
        else
        {
            echo "sql query execution failed ".mysqli_error($conn);
        }
    }
    else
    {
        echo "connection failed. something went wrong.";
    }

    return [];
}

function getAdminUser($uid)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT uid,name,email,phone,type FROM users WHERE uid=?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$uid);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);

        if($result && mysqli_num_rows($result)>0)
        {
            return mysqli_fetch_assoc($result);
        }
    }

    return null;
}

function isAdminUser($uid)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT users.uid
              FROM users
              INNER JOIN admin
              ON admin.aid=users.uid
              WHERE users.uid=?
              AND users.type='ADMIN'";

        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$uid);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);

        if($result && mysqli_num_rows($result)>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    return false;
}

function updateUserAsAdmin($uid,$name,$email,$phone,$adminUid)
{
    if(!isAdminUser($adminUid))
    {
        return false;
    }

    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT type FROM users WHERE uid=?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$uid);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);
        $user=mysqli_fetch_assoc($result);

        if(!$user || $user["type"]=="ADMIN")
        {
            return false;
        }

        $sql="SELECT uid FROM users WHERE email=? AND uid<>?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"si",$email,$uid);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result)>0)
        {
            return false;
        }

        $sql="UPDATE users
              SET name=?,email=?,phone=?
              WHERE uid=?";

        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"sssi",$name,$email,$phone,$uid);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    return false;
}

function deleteUserAsAdmin($uid,$adminUid)
{
    if(!isAdminUser($adminUid))
    {
        return false;
    }

    if($uid==$adminUid)
    {
        return false;
    }

    $conn=dbConnection();

    if(!$conn)
    {
        return false;
    }

    $sql="SELECT type FROM users WHERE uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);
    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);
    $user=mysqli_fetch_assoc($result);

    if(!$user)
    {
        return false;
    }

    if($user["type"]=="ADMIN")
    {
        return false;
    }

    mysqli_begin_transaction($conn);

    $sql="DELETE payment
          FROM payment
          INNER JOIN ticket
          ON payment.tid=ticket.tid
          INNER JOIN events
          ON ticket.eid=events.eid
          WHERE events.uid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE payment
          FROM payment
          INNER JOIN ticket
          ON payment.tid=ticket.tid
          WHERE ticket.uid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE FROM payment WHERE uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE ticket
          FROM ticket
          INNER JOIN events
          ON ticket.eid=events.eid
          WHERE events.uid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE FROM ticket WHERE uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE reports
          FROM reports
          INNER JOIN events
          ON reports.eid=events.eid
          WHERE events.uid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE FROM reports WHERE uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE promotion
          FROM promotion
          INNER JOIN events
          ON promotion.eid=events.eid
          WHERE events.uid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    if($user["type"]=="CORPORATE")
    {
        $sql="DELETE FROM promotion WHERE uid=?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$uid);

        if(!mysqli_stmt_execute($stmt))
        {
            mysqli_rollback($conn);
            return false;
        }
    }

    $sql="DELETE FROM events WHERE uid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    if($user["type"]=="CLIENT")
    {
        $sql="DELETE FROM client WHERE uid=?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$uid);

        if(!mysqli_stmt_execute($stmt))
        {
            mysqli_rollback($conn);
            return false;
        }
    }

    if($user["type"]=="CORPORATE")
    {
        $sql="DELETE FROM corporate WHERE uid=?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$uid);

        if(!mysqli_stmt_execute($stmt))
        {
            mysqli_rollback($conn);
            return false;
        }
    }

    $sql="DELETE FROM users
          WHERE uid=?
          AND type<>'ADMIN'";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$uid);

    if(mysqli_stmt_execute($stmt))
    {
        if(mysqli_stmt_affected_rows($stmt)>0)
        {
            mysqli_commit($conn);
            return true;
        }
        else
        {
            mysqli_rollback($conn);
            return false;
        }
    }
    else
    {
        mysqli_rollback($conn);
        return false;
    }
}

function markReportedEvents()
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="UPDATE events
              SET status='CLOSED'
              WHERE status='ACTIVE'
              AND EXISTS
              (
                  SELECT 1
                  FROM reports
                  WHERE reports.eid=events.eid
                  AND reports.status='ACTIVE'
              )";

        $stmt=mysqli_prepare($conn,$sql);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
    }

    return false;
}

function getAdminEvents()
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT *
              FROM events
              ORDER BY eid DESC";

        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);
        $events=[];

        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                if($row["status"]=="CLOSED")
                {
                    $row["status"]="REPORTED";
                }

                $events[]=$row;
            }

            return $events;
        }
    }

    return [];
}

function deleteEventAsAdmin($eid,$adminUid)
{
    if(!isAdminUser($adminUid))
    {
        return false;
    }

    $conn=dbConnection();

    if(!$conn)
    {
        return false;
    }

    mysqli_begin_transaction($conn);

    $sql="DELETE payment
          FROM payment
          INNER JOIN ticket
          ON payment.tid=ticket.tid
          WHERE ticket.eid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE FROM ticket WHERE eid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE FROM reports WHERE eid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE FROM promotion WHERE eid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="DELETE FROM events WHERE eid=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);

    if(mysqli_stmt_execute($stmt))
    {
        if(mysqli_stmt_affected_rows($stmt)>0)
        {
            mysqli_commit($conn);
            return true;
        }
        else
        {
            mysqli_rollback($conn);
            return false;
        }
    }
    else
    {
        mysqli_rollback($conn);
        return false;
    }
}

function getReports()
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT reports.*,
                     users.name,
                     events.title,
                     events.status AS event_status
              FROM reports
              LEFT JOIN users
              ON users.uid=reports.uid
              LEFT JOIN events
              ON events.eid=reports.eid
              ORDER BY reports.rid DESC";

        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);
        $reports=[];

        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                if($row["event_status"]=="CLOSED")
                {
                    $row["event_status"]="REPORTED";
                }

                $reports[]=$row;
            }

            return $reports;
        }
    }

    return [];
}

function reportSummary()
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT
              COUNT(*) AS total,
              COALESCE(SUM(status='ACTIVE'),0) AS active,
              COALESCE(SUM(status='RESOLVED'),0) AS resolved
              FROM reports";

        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            return mysqli_fetch_assoc($result);
        }
    }

    return [
        "total"=>0,
        "active"=>0,
        "resolved"=>0
    ];
}

function resolveReport($rid)
{
    $conn=dbConnection();

    if(!$conn)
    {
        return false;
    }

    $sql="SELECT eid
          FROM reports
          WHERE rid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$rid);
    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);

    if(!$result)
    {
        return false;
    }

    if(mysqli_num_rows($result)==0)
    {
        return false;
    }

    $report=mysqli_fetch_assoc($result);
    $eid=$report["eid"];

    mysqli_begin_transaction($conn);

    $sql="DELETE FROM reports
          WHERE rid=?";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$rid);

    if(!mysqli_stmt_execute($stmt))
    {
        mysqli_rollback($conn);
        return false;
    }

    $sql="SELECT COUNT(*) AS total
          FROM reports
          WHERE eid=?
          AND status='ACTIVE'";

    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i",$eid);
    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);
    $row=mysqli_fetch_assoc($result);

    if($row["total"]==0)
    {
        $sql="UPDATE events
              SET status='ACTIVE'
              WHERE eid=?";

        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$eid);

        if(!mysqli_stmt_execute($stmt))
        {
            mysqli_rollback($conn);
            return false;
        }
    }

    mysqli_commit($conn);

    return true;
}

function deleteEventFromReport($rid,$adminUid)
{
    if(!isAdminUser($adminUid))
    {
        return false;
    }

    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT eid
              FROM reports
              WHERE rid=?";

        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"i",$rid);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);

        if($result && mysqli_num_rows($result)>0)
        {
            $report=mysqli_fetch_assoc($result);
            $eid=$report["eid"];

            return deleteEventAsAdmin($eid,$adminUid);
        }
    }

    return false;
}

?>