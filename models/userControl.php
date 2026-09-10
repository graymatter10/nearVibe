<?php
require_once "dbConnect.php";


require_once __DIR__ . "/../models/dbConnect.php";

 // Parameters:    $email (string) 
 // Return type: array|null
 //   - array: the matching user's data as an associative array with keys *            "uid" (int, the user's id) and "type" (string, one of *            "CLIENT", "CORPORATE" or "ADMIN") when a user with that email *            is found.  *   - null:  when no user with that email exists in the database, or when
function findUserByEmail($email)
{
    $conn = dbConnection();

    if ($conn) {
        $sql = "SELECT uid, type FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            } else {
                return null;
            }
        } else {
            echo "sql query execution failed" . mysqli_error($conn);
            return null;
        }
    } else {
        echo "connection failed. something went wrong. ";
        return null;
    }
}

// Parameters:    none (reads $_SESSION["uid"])
// Return type: string|null
//   - string: the logged-in user's "type" column value ("CLIENT",
//             "CORPORATE" or "ADMIN") when $_SESSION["uid"] matches a
//             user in the database.
//   - null:   when $_SESSION["uid"] isn't set, or no user with that uid
//             exists in the database.
function getUserType()
{
    if (!isset($_SESSION["uid"])) {
        return null;
    }

    $conn = dbConnection();

    if ($conn) {
        $sql = "SELECT type FROM users WHERE uid = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["uid"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row["type"];
            } else {
                return null;
            }
        } else {
            echo "sql query execution failed" . mysqli_error($conn);
            return null;
        }
    } else {
        echo "connection failed. something went wrong. ";
        return null;
    }
}


?>