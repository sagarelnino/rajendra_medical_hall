<?php
require 'session_required.php';
require 'connection.php';
if(!$product->isExistProductById($_GET['id'])){
    $_SESSION['message'] = 'There is no such product id';
    header('location:products.php');
}
$singleProduct = $product->getProductById($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rajendra Medical Hall</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="rajlogo.ico">
    <link rel="stylesheet" href="bootstrap-3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin_navbar.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <style>
        h4{
            color: #eb9316;
        }
    </style>
</head>
<body>
<?php include 'admin_navbar.php' ?>
<div class="container">
    <h2 class="text-center">Product Details</h2>
    <h4 class="text-center"><?php echo $singleProduct['brandName'];?></h4>
    <h4 class="text-center"><?php echo $singleProduct['manufacturer'];?></h4>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div class="col-md-offset-2 col-md-8 my-table">
        <table class="table table-bordered">
            <tr>
                <th class="text-center">Brand Name</th>
                <td class="text-center"><?php echo $singleProduct['brandName'];?></td>
            </tr>
            <tr>
                <th class="text-center">Generic Name</th>
                <td class="text-center"><?php echo $singleProduct['genericName'];?></td>
            </tr>
            <tr>
                <th class="text-center">Manufacturer</th>
                <td class="text-center"><?php echo $singleProduct['manufacturer'];?></td>
            </tr>
            <tr>
                <th class="text-center">Pack Size</th>
                <td class="text-center"><?php echo $singleProduct['packSize'];?></td>
            </tr>
            <tr>
                <th class="text-center">Dosage Form</th>
                <td class="text-center"><?php echo $singleProduct['dosageForm'];?></td>
            </tr>
            <tr>
                <th class="text-center">In Stock</th>
                <td class="text-center"><?php echo $singleProduct['stockQuantity'];?></td>
            </tr>
            <tr>
                <th class="text-center">Buy price (unit)</th>
                <td class="text-center">
                    <?php
                    if($singleProduct['buyPrice']){
                        echo $singleProduct['buyPrice'].' TK';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">MRP (unit)</th>
                <td class="text-center"><?php echo $singleProduct['salePrice'].' TK';?></td>
            </tr>
            <tr>
                <th class="text-center">Kept at</th>
                <td class="text-center"><?php echo $singleProduct['keptWhere'];?></td>
            </tr>
            <tr>
                <th class="text-center">Sold Times</th>
                <td class="text-center"><?php echo $singleProduct['soldTimes'];?></td>
            </tr>
            <tr>
                <th class="text-center">Added On</th>
                <td class="text-center"><?php echo $singleProduct['created'];?></td>
            </tr>
            <tr>
                <th class="text-center">Link</th>
                <td class="text-center">
                    <?php
                        if($singleProduct['url']){?>
                            <a href="<?php echo $singleProduct['url']?>" target="_blank">Visit from Medex</a>
                        <?php }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>