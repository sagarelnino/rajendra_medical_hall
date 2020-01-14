<?php
require 'session_required.php';
require 'connection.php';
$page = 'add_product';
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
        $created = date('Y-m-d H:i:s');
        $product->addProduct($brandName,$genericName,$manufacturer,$packSize,$dosageForm,$stockQuantity,$buyPrice,$salePrice,$keptWhere,$created);
        $logDetails = 'New product brand name '.$brandName.' ,generic name '.$genericName.' has been added by '.$_SESSION['adminName'];
        $log->addLog($logDetails,$_SESSION['adminId'],$created);
        $_SESSION['message'] = 'Successfully Added';
        header('location:products.php');
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
                <input type="text" class="form-control" name="brandName" id="brandName" placeholder="Enter Brand Name of product" required>
                <span id="brandNameError" style="color: orangered">Please Enter Brand Name</span>
            </div>
            <div class="form-group">
                <label for="genericName">Generic Name</label>
                <input type="text" class="form-control" name="genericName" id="genericName" placeholder="Enter Generic Name of product">
            </div>
            <div class="form-group">
                <label for="manufacturer">Manufacturer (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="manufacturer" id="manufacturer" placeholder="Enter Manufacturer (i.e. Beximco)" required>
                <div id="manufacturerSuggestion"></div>
                <span id="manufacturerError" style="color: orangered">Please Enter Manufacturer</span>
            </div>
            <div class="form-group">
                <label for="packSize">Pack Size (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="packSize" id="packSize" placeholder="Enter Pack Size (i.e. 500mg)" required>
                <div id="packSizeSuggestion"></div>
                <span id="packSizeError" style="color: orangered">Please Enter pack size</span>
            </div>
            <div class="form-group">
                <label for="dosageForm">Dosage Form</label>
                <input type="text" class="form-control" name="dosageForm" id="dosageForm" placeholder="Enter Dosage Form (i.e. Tablet, Syrup)">
                <div id="dosageFormSuggestion"></div>
            </div>
            <div class="form-group">
                <label for="stockQuantity">In Stock</label>
                <input type="number" class="form-control" name="stockQuantity" id="stockQuantity" placeholder="Enter Stock Quantity">
                <span id="stockQuantityError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="buyPrice">Buy Price</label>
                <input type="text" class="form-control" name="buyPrice" id="buyPrice" placeholder="Enter the unit price you purchased this product (in TK)">
                <span id="buyPriceError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="salePrice">Sale Price (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="salePrice" id="salePrice" placeholder="Enter the unit price you sell this product (in TK)" required>
                <span id="salePriceError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="keptWhere">Where you are keeping this</label>
                <textarea class="form-control" name="keptWhere" id="keptWhere" placeholder="Where you will keep this product in your store"></textarea>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Add">
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
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
    $(document).ready(function () {
        $('#manufacturer').keyup(function () {
            var query = $(this).val();
            if(query != ''){
                $.ajax({
                    url:"manufacturer_list.php",
                    method:"POST",
                    data:{query:query},
                    success:function (data) {
                        $('#manufacturerSuggestion').fadeIn();
                        $('#manufacturerSuggestion').html(data);
                    }
                });
            }
        }) ;

        $('#dosageForm').keyup(function () {
            var query = $(this).val();
            if(query != ''){
                $.ajax({
                    url:"dosageForm_list.php",
                    method:"POST",
                    data:{query:query},
                    success:function (data) {
                        $('#dosageFormSuggestion').fadeIn();
                        $('#dosageFormSuggestion').html(data);
                    }
                });
            }
        }) ;

        $('#packSize').keyup(function () {
            var query = $(this).val();
            if(query != ''){
                $.ajax({
                    url:"packSize_list.php",
                    method:"POST",
                    data:{query:query},
                    success:function (data) {
                        $('#packSizeSuggestion').fadeIn();
                        $('#packSizeSuggestion').html(data);
                    }
                });
            }
        }) ;

            $('#packSizeSuggestion').on('click','li',function () {
               // console.log("kkkkk");
                $('#packSize').val($(this).text());
                $('#packSizeSuggestion').fadeOut();
            });


            $('#dosageFormSuggestion').on('click','li',function () {// console.log("kkkkk");
                $('#dosageForm').val($(this).text());
                $('#dosageFormSuggestion').fadeOut();
            });


            $('#manufacturerSuggestion').on('click','li',function () { //console.log("kkkkk");
                $('#manufacturer').val($(this).text());
                $('#manufacturerSuggestion').fadeOut();
            });



    });
</script>
</body>
</html>