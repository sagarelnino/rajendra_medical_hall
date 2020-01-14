<?php
    require 'session_required.php';
    require 'connection.php';
    $productDetails = $product->getProductById($_GET['id']);
    $product->deleteProduct($_GET['id']);
    if($product->isExistAnyLoanedProductByProductId($_GET['id'])){
        $product->deleteLoanedProducts($_GET['id']);
    }
    $logDetails = 'BrandName:'.$productDetails['brandName'].',GenericName:'.$productDetails['genericName'].',Manufacturer:'.$productDetails['manufacturer'].'::this product has been deleted by '.$_SESSION['adminName'];
    $created = date('Y-m-d H:i:s');
    $log->addLog($logDetails,$_SESSION['adminId'],$created);
    $_SESSION['message'] = 'Product Deleted';
    header('location:products.php');
?>