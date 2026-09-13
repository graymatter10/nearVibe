<?php
if(!isset($currentUser))
{
    http_response_code(403);
    exit("Open this page through its view.");
}

require_once("../../models/admin/adminModel.php");

$message="";
$editUser=null;

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $uid=(int)($_POST['uid'] ?? 0);
    $action=$_POST['action'] ?? '';

    if($action=='update')
    {
        $name=trim($_POST['name'] ?? '');
        $email=trim($_POST['email'] ?? '');
        $phone=trim($_POST['phone'] ?? '');

        if($name=='' || $email=='')
        {
            $message="Name and email are required.";
        }
        elseif(updateUserAsAdmin($uid,$name,$email,$phone,$_SESSION['uid']))
        {
            $message="User modified successfully.";
        }
        else
        {
            $message="User could not be modified.";
        }
    }
    elseif($action=='delete')
    {
        if(deleteUserAsAdmin($uid,$_SESSION['uid']))
        {
            $message="User deleted successfully.";
        }
        else
        {
            $message="User could not be deleted.";
        }
    }
}

if(isset($_GET['edit']))
{
    $editUid=(int)$_GET['edit'];
    $editUser=getAdminUser($editUid);
}

$users=getUsers();
?>
