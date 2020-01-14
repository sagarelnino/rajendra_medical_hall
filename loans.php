<?php
require 'session_required.php';
require 'connection.php';
$page = 'loans';
$allLoans = $product->getAllLoanRecords();
if(empty($allLoans)){
    $_SESSION['message'] = 'No record in the list';
}
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
</head>
<body>
<?php include 'admin_navbar.php' ?>
<div class="container-fluid">
    <h2 class="text-center">Loaned products list</h2>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div class="my-table">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">Brand Name</th>
                <th class="text-center">Manufacturer</th>
                <th class="text-center">Dosage Form</th>
                <th class="text-center">Pack Size</th>
                <th class="text-center">Loaned From</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Taken By</th>
                <th class="text-center">Date</th>
                <th class="text-center">Back</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allLoans as $singleLoan){
                $productDetails = $product->getProductById($singleLoan['productId']);
                ?>
                <tr title="Sale Price: <?php echo $productDetails['salePrice']?>">
                    <td><?php echo $productDetails['brandName'];?></td>
                    <td><?php echo $productDetails['manufacturer'];?></td>
                    <td><?php echo $productDetails['dosageForm'];?></td>
                    <td><?php echo $productDetails['packSize'];?></td>
                    <td><?php echo $singleLoan['takenFrom'];?></td>
                    <td><?php echo $singleLoan['takenQuantity'];?></td>
                    <td>
                        <?php
                            $adminDetails = $admin->getAdminById($singleLoan['takenBy']);
                            echo $adminDetails['fullname'];
                        ?>
                    </td>
                    <td><?php echo $singleLoan['created'];?></td>
                    <td>
                        <form method="post" action="back_loan.php">
                            <input type="number" name="back_quantity" min="1" max="<?php echo $singleLoan['takenQuantity']?>">
                            <input type="hidden" name="productId" value="<?php echo $productDetails['id']?>">
                            <input type="hidden" name="loanId" value="<?php echo $singleLoan['id']?>">
                            <input class="btn btn-default" onclick="return(confirm('Are you sure?'))" type="submit" name="submit" value="Back">
                        </form>
                    </td>
                    <td><a title="Product Details" target="_blank" href="product_details.php?id=<?php echo $productDetails['id']?>" class="btn btn-info">Product</a> <a title="It would add stock quantity" onclick="return(confirm('Are you sure?'))" href="dismiss_loan.php?loan_id=<?php echo $singleLoan['id'];?>" class="btn btn-success">Dismiss</a> </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>
<?php include 'footer.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>