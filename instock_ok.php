<?php
    require 'session_required.php';
    require 'connection.php';
    $id = $_GET['id'];
    $product->updateIsInStockOk($id);
    header("location: products.php");
?>