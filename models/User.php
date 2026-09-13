<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

  
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }


   
    public function findByEmailAndType($email, $type)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND type = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $email, $type);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }


   
    public function createUser($name, $email, $password, $phone, $type)
    {
        $sql = "INSERT INTO users 
                (name, email, password, phone, reset_token, type)
                VALUES (?, ?, ?, ?, NULL, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $name,
            $email,
            $password,
            $phone,
            $type
        );

        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn);
        }

        return false;
    }


   
    public function saveResetToken($uid, $token)
    {
        $sql = "UPDATE users SET reset_token = ? WHERE uid = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "si", $token, $uid);

        return mysqli_stmt_execute($stmt);
    }


    public function findByEmailAndToken($email, $token)
    {
        $sql = "SELECT * FROM users 
                WHERE email = ? AND reset_token = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $email, $token);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    public function updatePassword($uid, $password)
    {
        $sql = "UPDATE users 
                SET password = ?, reset_token = NULL
                WHERE uid = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "si", $password, $uid);

        return mysqli_stmt_execute($stmt);
    }


   
    public function emailExists($email)
    {
        $sql = "SELECT uid FROM users WHERE email = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) > 0;
    }
}

?>