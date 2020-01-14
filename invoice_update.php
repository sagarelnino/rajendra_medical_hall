<?php
require 'session_required.php';
require 'connection.php';
$data=$_POST["data"];
$price=$_POST["price"];
$discount=$_POST["discount"];
$userId = $_SESSION['adminId'];
$netPrice = $price;
$total = $netPrice-$discount;
$invoiceItems = '';
foreach ($data as $singleData){
    $product->addSoldTimes($singleData[4],$singleData[6]);
    $invoiceItems .= implode(',',$singleData);
    $invoiceItems .= '|';
    //last column id
}
$invoiceItems = substr($invoiceItems,0,-1);
$created = date('Y-m-d H:i:s');
$newId = $invoice->addInvoice($userId,$invoiceItems,$netPrice,$discount,$total,$created);
$logDetails = 'Invoice created of taka '.$total.',net price:'.$netPrice.',discount:'.$discount.' of items '.$invoiceItems.' by '.$_SESSION['adminName'];
$created = date('Y-m-d H:i:s');
$log->addLog($logDetails,$_SESSION['adminId'],$created);
echo $newId;
/*var_dump($data);
var_dump($price);
var_dump($discount);*/
?>