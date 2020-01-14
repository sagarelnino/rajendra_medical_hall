<?php
    require 'session_required.php';
    require 'connection.php';
    $adminTypeDetails = $adminType->getadminTypeByTextId($_GET['textId']);
    $adminType->deleteAdminType($_GET['textId']);
    $logDetails = 'Admin type named '.$adminTypeDetails['name'].' of textId '.$adminTypeDetails['textId'].' has been deleted by '.$_SESSION['adminName'];
    $created = date('Y-m-d H:i:s');
    $log->addLog($logDetails,$_SESSION['adminId'],$created);
    $_SESSION['message'] = 'Admin Type Deleted';
    header('location:admin_types.php');
?>