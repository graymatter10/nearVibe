<?php

class Client
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createClient($uid)
    {
        $sql = "INSERT INTO client (uid) VALUES (?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $uid);

        return mysqli_stmt_execute($stmt);
    }
}

?>