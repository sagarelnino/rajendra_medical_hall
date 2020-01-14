<?php
require 'session_required.php';
require 'connection.php';
$page = 'invoice';
$invoiceId = $_GET['id'];
if(!$invoice->isExistInvoiceById($invoiceId)){
    $_SESSION['message'] = 'This invoice id does not exist';
    header("location: admin.php");
}
$singleInvoice = $invoice->getInvoiceById($invoiceId);
$adminDetails = $admin->getAdminById($_SESSION['adminId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Theme Made By www.w3schools.com - No Copyright -->
    <title>Rajendra Medical Hall</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="rajlogo.ico">
    <link rel="stylesheet" href="bootstrap-3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin_navbar.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <style>
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
            #printBtn{ display: none; }
        }
    </style>
</head>
<body>
<?php include 'admin_navbar.php' ?>
<div class="container">
    <button style="margin-top: 1%; position: fixed" id="printBtn" class="btn btn-info" onclick="window.print()">Print this invoice</button>
    <div class="row page-header">
        <div class="col-md-offset-3 col-md-6 shop-details">
            <h2 class="text-center title">RAJENDRA MEDICAL HALL</h2>
            <small class="add">
                <b>Address:</b> Niltuly, Faridpur<br>
                <b>Proprietor:</b> Sanjib Saha Akash<br>
                <b>Phone:</b> 01888888888
            </small>
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Manufacturer</th>
                    <th>Pack Size</th>
                    <th>Dosage Form</th>
                    <th>Quantity</th>
                    <th>total</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $invoiceItemsArr = explode('|',$singleInvoice['invoiceItems']);
                #die('died'.'<pre>'.print_r($invoiceItemsArr, true));
                foreach ($invoiceItemsArr as $singleInvoiceItem){?>
                   <tr>
                       <?php
                        $menu = explode(',',$singleInvoiceItem);
                        $i=1;
                        foreach ($menu as $key=>$value){
                            if($i==7){
                                continue;
                            }
                            $i++;
                            ?>
                            <td><?php echo $value;?></td>

                        <?php }
                       ?>
                   </tr>
                <?php }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><b>NET PRICE</b></td>
                    <td><?php echo $singleInvoice['netPrice']?></td>
                </tr>
                <tr>
                    <td colspan="5"><b>DISCOUNT</b></td>
                    <td><?php echo $singleInvoice['discount']?></td>
                </tr>
                <tr>
                    <td colspan="5"><b>TOTAL</b></td>
                    <th><?php echo $singleInvoice['total']?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="text-right invoice-by">
        Invoice Created By:
        <?php
        if(!empty($adminDetails['fullname'])){
            echo $adminDetails['fullname'];
        }else{
            echo "Unknown";
        } ?><br>
        Date: <?php echo $singleInvoice['created'];?>
    </div>
</div>
<?php include 'footer_fixed.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>