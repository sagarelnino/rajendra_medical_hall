<?php
    require 'session_required.php';
    require 'connection.php';
    if(isset($_GET['loan_id'])){
        $loanDetails = $product->getLoanById($_GET['loan_id']);
        $product->dismissLoan($loanDetails['takenQuantity'],$loanDetails['productId']);
        $product->deleteLoan($_GET['loan_id']);
        //add log here;
        header("location:loans.php");
    }

?>