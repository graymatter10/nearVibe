<?php

require_once "dbConnect.php";

function emailExists($email)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"SELECT uid FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt,"s",$email);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result)>0;
}

function verifyPassword($password,$stored)
{
    if(substr($stored,0,3)=="p1$")
    {
        $data=base64_decode(substr($stored,3),true);
        if($data===false || strlen($data)!=32)
        {
            return false;
        }
        $salt=substr($data,0,8);
        $hash=hash_pbkdf2("sha256",$password,$salt,600000,24,true);
        return hash_equals(substr($data,8),$hash);
    }

    return password_verify($password,$stored) || (strlen($stored)==32 && hash_equals(strtolower($stored),md5($password)));
}

function findUserByEmailFull($email)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt,"s",$email);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result)>0)
    {
        return mysqli_fetch_assoc($result);
    }

    return null;
}

function findUserByEmailAndToken($email,$token)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"SELECT * FROM users WHERE email=? AND reset_token=?");
    mysqli_stmt_bind_param($stmt,"ss",$email,$token);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result)>0)
    {
        return mysqli_fetch_assoc($result);
    }

    return null;
}

function createUser($name,$email,$password,$phone,$type)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"INSERT INTO users (name,email,password,phone,type) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt,"sssss",$name,$email,$password,$phone,$type);

    if(mysqli_stmt_execute($stmt))
    {
        return mysqli_insert_id($conn);
    }

    return false;
}

function createClientRow($uid)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"INSERT INTO client (uid) VALUES (?)");
    mysqli_stmt_bind_param($stmt,"i",$uid);
    return mysqli_stmt_execute($stmt);
}

function createCorporateRow($uid,$companyName)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"INSERT INTO corporate (uid,company_name) VALUES (?,?)");
    mysqli_stmt_bind_param($stmt,"is",$uid,$companyName);
    return mysqli_stmt_execute($stmt);
}

function saveResetToken($uid,$token)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"UPDATE users SET reset_token=? WHERE uid=?");
    mysqli_stmt_bind_param($stmt,"si",$token,$uid);
    return mysqli_stmt_execute($stmt);
}

function updateUserPassword($uid,$password)
{
    $conn=dbConnection();
    $stmt=mysqli_prepare($conn,"UPDATE users SET password=?, reset_token=NULL WHERE uid=?");
    mysqli_stmt_bind_param($stmt,"si",$password,$uid);
    return mysqli_stmt_execute($stmt);
}

?>
