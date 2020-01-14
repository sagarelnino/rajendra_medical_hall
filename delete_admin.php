<?php
require 'session_required.php';
require 'connection.php';
$adminDetails = $admin->getAdminById($_GET['id']);
$admin->deleteAdmin($_GET['id']);
$logDetails = 'Admin named '.$adminDetails['username'].' of type '.$adminDetails['adminTypeTextId'].' has been deleted by '.$_SESSION['adminName'];
$created = date('Y-m-d H:i:s');
$log->addLog($logDetails,$_SESSION['adminId'],$created);
$_SESSION['message'] = 'Admin Deleted';
header('location:admins.php');
?>