<?php
    require 'session_required.php';
    require 'connection.php';
    if(isset($_POST['submit']) && !empty($_POST['back_quantity'])){
        $back_quantity = $_POST['back_quantity'];
        $product->dismissLoan($back_quantity,$_POST['productId']);
        $product->backLoan($back_quantity,$_POST['loanId']);
        $logDetails = 'Loan of product id '.$_POST['productId'].' has been repaid of amount '.$back_quantity.' by '.$_SESSION['adminName'];
        $created = date('Y-m-d H:i:s');
        $log->addLog($logDetails,$_SESSION['adminId'],$created);
        header('location:loans.php');
    }
?>