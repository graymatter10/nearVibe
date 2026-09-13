<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}
if ($_SERVER['REQUEST_METHOD']=='POST')
{
    if ($_POST['action']=='profile')
    {
        $name=trim($_POST['name']);
        $email=trim($_POST['email']);
        $phone=trim($_POST['phone']);
        $other=findUser($email);
        if ($name=='' || strlen($name)>40 || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($email)>30 || strlen($phone)>14)
        {
            $message="Check name, email (30 characters maximum) and phone.";
        }
        elseif ($other && $other['uid']!=$_SESSION['uid'])
        {
            $message="Email already used.";
        }
        else
        {
            updateProfile($_SESSION['uid'],$name,$email,$phone);
            $_SESSION['name']=$name;
            $_SESSION['email']=$email;
            $currentUser=getUser($_SESSION['uid']);
            $message="Profile saved.";
        }
    }
    elseif ($_POST['action']=='password')
    {
        if (!checkPassword($_POST['currentPassword'],$currentUser['password']))
        {
            $message="Current password is incorrect.";
        }
        elseif (strlen($_POST['newPassword'])<6 || $_POST['newPassword']!=$_POST['confirmPassword'])
        {
            $message="Use at least 6 characters and matching passwords.";
        }
        else
        {
            if(savePassword($_SESSION['uid'],$_POST['newPassword']))
            {
                $message="Password changed.";
            }
            else
            {
                $message="Password could not be saved. Please try again.";
            }
        }
    }
}
?>
