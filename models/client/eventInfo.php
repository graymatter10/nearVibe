<?php
require_once __DIR__ . "/../dbConnect.php";

function getAllEvents()
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT eid, uid, title, description, tprice, latitude, longitude, type FROM events";
        $result=mysqli_query($conn, $sql);
        $events=[];

        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $events[]=$row;
            }

            return $events;
        }
        else
        {
            echo "sql query execution failed".mysqli_error($conn);
            return [];
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return [];
    }
}

function countEventsByUid($uid)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT COUNT(*) AS total FROM events WHERE uid=?";
        $stmt=mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $uid);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            return $row["total"];
        }
        else
        {
            echo "sql query execution failed".mysqli_error($conn);
            return 0;
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return 0;
    }
}

function countTicketsByUid($uid)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT COUNT(*) AS total FROM ticket WHERE uid=?";
        $stmt=mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $uid);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            return $row["total"];
        }
        else
        {
            echo "sql query execution failed".mysqli_error($conn);
            return 0;
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return 0;
    }
}

function countReportsByUid($uid)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT COUNT(*) AS total, SUM(status='RESOLVED') AS resolved FROM reports WHERE uid=?";
        $stmt=mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $uid);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            return ["total"=>(int)$row["total"], "resolved"=>(int)$row["resolved"]];
        }
        else
        {
            echo "sql query execution failed".mysqli_error($conn);
            return ["total"=>0, "resolved"=>0];
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return ["total"=>0, "resolved"=>0];
    }
}

?>