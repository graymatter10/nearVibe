<?php

class Corporate
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    
    public function createCorporate($uid, $companyName)
    {
        $sql = "INSERT INTO corporate (uid, company_name)
                VALUES (?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "is",
            $uid,
            $companyName
        );

        return mysqli_stmt_execute($stmt);
    }
}

?>