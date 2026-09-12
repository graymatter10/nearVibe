<?php
require_once("../../models/dbConnect.php");
function findUser($email)
{
    $conn = dbConnection();
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
function getUser($uid)
{
    $conn = dbConnection();
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE uid=?");
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
function checkPassword($password, $stored)
{
     
    // p1$ stores an 8-byte random salt and 24-byte PBKDF2 hash in 47 characters.
    if(substr($stored,0,3)=="p1$")
    {
        $data=base64_decode(substr($stored,3),true);
        if($data===false || strlen($data)!=32) { return false; }
        $salt=substr($data,0,8);
        $hash=hash_pbkdf2("sha256",$password,$salt,600000,24,true);
        return hash_equals(substr($data,8),$hash);
    }
    // Keep existing demo MD5 passwords usable.
    return password_verify($password,$stored) || (strlen($stored)==32 && hash_equals(strtolower($stored),md5($password)));
}
function savePassword($uid, $password)
{
    $conn=dbConnection();
    $salt=random_bytes(8);
    $hash="p1$".base64_encode($salt.hash_pbkdf2("sha256",$password,$salt,600000,24,true));
    $stmt=mysqli_prepare($conn,"UPDATE users SET password=?, reset_token=NULL WHERE uid=?");
    mysqli_stmt_bind_param($stmt,"si",$hash,$uid);
    return mysqli_stmt_execute($stmt);
}

function updateProfile($uid, $name, $email, $phone)
{
    $conn=dbConnection();
    $sql="UPDATE users SET name=?,email=?,phone=? WHERE uid=?";
    $stmt=mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $uid);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt)>0;
}
?>
