<?php
    require 'session_required.php';
    require 'connection.php';
    $productId = 7168;
    var_dump($product->isExistAnyLoanedProductByProductId($productId));
?>