<?php
    require 'session_required.php';
    require 'connection.php';
    $log->deleteLog($_GET['id']);
    $logDetails = 'Log has been deleted by '.$_SESSION['adminName'];
    $created = date('Y-m-d H:i:s');
    $log->addLog($logDetails,$_SESSION['adminId'],$created);
    $_SESSION['message'] = 'Log has been deleted';
    header('location:logs.php');
?>