<?php
require 'session_required.php';
require 'connection.php';
$productId = $_GET['id'];
if(!$product->isExistProductById($productId)){
    $_SESSION['message'] = 'There is no such product of this id';
    header('location:products.php');
}
$productDetails =$product->getProductById($productId);
if(isset($_POST['submit'])){
    $brandName = filter($_POST['brandName']);
    $genericName = filter($_POST['genericName']);
    $manufacturer = filter($_POST['manufacturer']);
    $packSize = filter($_POST['packSize']);
    $dosageForm = filter($_POST['dosageForm']);
    $stockQuantity = filter($_POST['stockQuantity']);
    $buyPrice = filter($_POST['buyPrice']);
    $salePrice = filter($_POST['salePrice']);
    $keptWhere = filter($_POST['keptWhere']);
    if(!empty($brandName) && !empty($manufacturer) && !empty($packSize) && !empty($salePrice) && $salePrice != 0){
        $updated = date('Y-m-d H:i:s');
        $product->updateProductById($brandName,$genericName,$manufacturer,$packSize,$dosageForm,$stockQuantity,$buyPrice,$salePrice,$keptWhere,$updated,$productId);
        $logDetails = '';
        if($brandName != $productDetails['brandName']){
            $logDetails .= 'Brand Name has been changed from: '.$productDetails['brandName'].' to '.$brandName;
        }
        if($genericName != $productDetails['genericName']){
            $logDetails .= 'Generic Name has been changed from: '.$productDetails['genericName'].' to '.$genericName;
        }
        if($manufacturer != $productDetails['manufacturer']){
            $logDetails .= 'Manufacturer has been changed from: '.$productDetails['manufacturer'].' to '.$manufacturer;
        }
        if($packSize != $productDetails['packSize']){
            $logDetails .= 'Packsize has been changed from: '.$productDetails['packSize'].' to '.$packSize;
        }
        if($dosageForm != $productDetails['dosageForm']){
            $logDetails .= 'Dosage form has been changed from: '.$productDetails['dosageForm'].' to '.$dosageForm;
        }
        if($stockQuantity != $productDetails['stockQuantity']){
            $logDetails .= 'Stock Quantity has been changed from: '.$productDetails['stockQuantity'].' to '.$stockQuantity;
        }
        if($buyPrice != $productDetails['buyPrice']){
            $logDetails .= 'Buy Price has been changed from: '.$productDetails['buyPrice'].' to '.$buyPrice;
        }
        if($salePrice != $productDetails['salePrice']){
            $logDetails .= 'Sale Price has been changed from: '.$productDetails['salePrice'].' to '.$salePrice;
        }
        if($logDetails){
            $logDetails .= ' changed by '.$_SESSION['adminName'];
            $log->addLog($logDetails,$_SESSION['adminId'],$updated);
        }
        $_SESSION['message'] = 'Successfully Updated';
        header('location:product_details.php?id='.$productDetails['id']);
    }else{
        $_SESSION['message'] = 'You need to fill up name and textId and select some roles';
    }
}
function filter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Rajendra Medical Hall</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="rajlogo.ico">
    <link rel="stylesheet" href="bootstrap-3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin_navbar.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
</head>
<body>
<?php include 'admin_navbar.php' ?>
<div class="container">
    <h3 class="text-center">Add New Product (<span class="mandatory"> * </span> fields are mandatory)</h3>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div class="col-md-offset-2 col-md-8 my-table">
        <form method="POST" onsubmit="return validate()">
            <div class="form-group">
                <label for="brandName">Brand Name (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="brandName" id="brandName" value="<?php echo $productDetails['brandName']?>" required>
                <span id="brandNameError" style="color: orangered">Please Enter Brand Name</span>
            </div>
            <div class="form-group">
                <label for="genericName">Generic Name</label>
                <input type="text" class="form-control" name="genericName" id="genericName" value="<?php echo $productDetails['genericName']?>">
            </div>
            <div class="form-group">
                <label for="manufacturer">Manufacturer (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="manufacturer" id="manufacturer" value="<?php echo $productDetails['manufacturer']?>" required>
                <span id="manufacturerError" style="color: orangered">Please Enter Manufacturer</span>
            </div>
            <div class="form-group">
                <label for="packSize">Pack Size (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="packSize" id="packSize" value="<?php echo $productDetails['packSize']?>" required>
                <span id="packSizeError" style="color: orangered">Please Enter pack size</span>
            </div>
            <div class="form-group">
                <label for="dosageForm">Dosage Form</label>
                <input type="text" class="form-control" name="dosageForm" id="dosageForm" value="<?php echo $productDetails['dosageForm']?>">
            </div>
            <div class="form-group">
                <label for="stockQuantity">In Stock</label>
                <input type="number" class="form-control" name="stockQuantity" id="stockQuantity" value="<?php echo $productDetails['stockQuantity']?>">
                <span id="stockQuantityError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="buyPrice">Buy Price</label>
                <input type="number" class="form-control" name="buyPrice" id="buyPrice" value="<?php echo $productDetails['buyPrice']?>">
                <span id="buyPriceError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="salePrice">Sale Price (<span class="mandatory"> * </span>)</label>
                <input type="number" class="form-control" name="salePrice" id="salePrice" value="<?php echo $productDetails['salePrice']?>" required>
                <span id="salePriceError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="keptWhere">Where you are keeping this</label>
                <textarea class="form-control" name="keptWhere" id="keptWhere" placeholder="Where you will keep this product in your store"><?php echo $productDetails['keptWhere']?></textarea>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Update">
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
    document.getElementById("brandNameError").style.display = "none";
    document.getElementById("manufacturerError").style.display = "none";
    document.getElementById("packSizeError").style.display = "none";
    document.getElementById("stockQuantityError").style.display = "none";
    document.getElementById("buyPriceError").style.display = "none";
    document.getElementById("salePriceError").style.display = "none";
    function validate() {
        var brandName = document.getElementById('brandName').value;
        var manufacturer = document.getElementById('manufacturer').value;
        var packSize = document.getElementById('packSize').value;
        var stockQuantity = document.getElementById('stockQuantity').value;
        var buyPrice = document.getElementById('buyPrice').value;
        var salePrice = document.getElementById('salePrice').value;
        if(brandName.trim() == ""){
            document.getElementById("brandNameError").style.display = "block";
            document.getElementById('brandName').focus();
            return false;
        }
        if(manufacturer.trim() == ""){
            document.getElementById("manufacturerError").style.display = "block";
            document.getElementById('manufacturer').focus();
            return false;
        }
        if(packSize.trim() == ""){
            document.getElementById("packSizeError").style.display = "block";
            document.getElementById('packSize').focus();
            return false;
        }
        if(stockQuantity.trim() == ""){
            document.getElementById('stockQuantityError').innerHTML = 'Stock quantity field should be a number';
            document.getElementById('stockQuantity').focus();
            return false;
        }
        if(validatePrice(buyPrice.trim()) === false){
            document.getElementById('buyPriceError').innerHTML = 'Enter a valid price';
            document.getElementById('buyPrice').focus();
            return false;
        }
        if(validatePrice(salePrice.trim()) === false || salePrice.trim() == ""){
            document.getElementById('salePriceError').innerHTML = 'Enter a valid price';
            document.getElementById('salePrice').focus();
            return false;
        }
        return true;
    }
    function validatePrice(price) {
        var regex = /^(\$|)([1-9]\d{0,2}(\,\d{3})*|([1-9]\d*))(\.\d{2})?$/;
        var passed = price.match(regex);
        if (passed == null) {
            return false;
        }
        return true;
    }
</script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>