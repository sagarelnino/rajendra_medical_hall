<?php
    require 'session_required.php';
    require 'connection.php';
    if($_POST['submit']){
        #die('died'.'<pre>'.print_r($_POST, true));
        if(!empty($_POST['stockQuantity'])){
            $product->dismissLoan($_POST['stockQuantity'],$_POST['productId']);
            $logDetails = 'Stock quantity '.$_POST['stockQuantity'].' has been added of product id '.$_POST['productId'].' by '.$_SESSION['adminName'];
            $created = date('Y-m-d H:i:s');
            $log->addLog($logDetails,$_SESSION['adminId'],$created);
            header('location:products.php');
        }
    }
?>