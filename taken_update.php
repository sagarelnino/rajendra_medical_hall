<?php
    require 'session_required.php';
    require 'connection.php';
    $data =$_POST['data'];
    $takenBy = $_SESSION['adminId'].':'.$_SESSION['adminName'];
    $created  =date('Y-m-d H:i:s');
    foreach($data as $singleData){
        if(!empty($singleData)){
            $product->addLoan($singleData[2],$singleData[0],$singleData[1],$takenBy,$created);
        }
    }
?>