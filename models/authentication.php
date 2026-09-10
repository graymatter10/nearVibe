<?php
require_once "dbConnect.php";



function register(){ }

function updateAccount(){ }



function login($userId, $pass)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT * from users WHERE userId=? AND pass=?";
        $stmt=mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $userId, $pass);
        mysqli_stmt_execute($stmt); 
        $result=mysqli_stmt_get_result($stmt);
        $users=[];
        if($result)
        {
            if(mysqli_num_rows($result)>0)
            {
                while($row=mysqli_fetch_assoc($result))
                    {
                        return $row;
                    }
               
                
            }
            else
            {
                return null;
            }
        }
        else
        {
            echo "sql query execution failed".mysqli_error($conn);
        }

    }
    else
    {
        echo "connection failed. something went wrong. ";   
    }
}



?>