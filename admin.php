<?php
    require 'session_required.php';
    require 'connection.php';
    $page = 'home';
    $productAll = $product->getTopProducts();
    $allExpense = $expense->getTopExpense();
    $latestProducts = $product->getLatestProducts();
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
<style>
    h2{
        text-shadow: 2px 4px #fff;
    }
</style>
<body>
<?php include 'admin_navbar.php' ?>
    <?php
        if(!empty($_SESSION['message'])){?>
            <script>
                alert('<?php echo $_SESSION['message'];?>');
            </script>
        <?php }
        unset($_SESSION['message']);
    ?>
    <div class="container">
        <div class="page-header"><h2 class="text-center">WELCOME ADMIN <small><i>Have a summarized look at your business</i></small></h2></div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-xs-12">
                <div class="short-border">
                    <h4>Today's Summary</h4>
                    <b>Total Sale:</b>
                    <?php
                    if($invoice->getAllInvoicesSumByDate(date('Y-m-d'))[0]){
                        echo $invoice->getAllInvoicesSumByDate(date('Y-m-d'))[0];
                    }else{
                        echo "No sale yet";
                    }
                    ?>, <b>Total Expense: </b>
                    <?php
                    if($expense->getAllExpenseSumByDate(date('Y-m-d'))[0]){
                        echo $expense->getAllExpenseSumByDate(date('Y-m-d'))[0];
                    }else{
                        echo 'No expense yet';
                    }
                    ?>
                    <h3 style="color: #eb9316"> Total Income of today: <?php echo ($invoice->getAllInvoicesSumByDate(date('Y-m-d'))[0]-$expense->getAllExpenseSumByDate(date('Y-m-d'))[0]) ?> </h3>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 2%;">
            <div class="col-md-6 col-xs-12 my-div">
                <h4 class="text-center">Top 5 products</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Manufacturer</th>
                        <th class="text-center">Pack Size</th>
                        <th class="text-center">Dosage Form</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($productAll as $singleProduct){
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $singleProduct['brandName'];?></td>
                            <td class="text-center"><?php echo $singleProduct['manufacturer'];?></td>
                            <td class="text-center"><?php echo $singleProduct['packSize'];?></td>
                            <td class="text-center"><?php echo $singleProduct['dosageForm'];?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <a class="btn btn-info" style="float: right" href="products.php">See more...</a>
            </div>

            <div class="col-md-6 col-xs-12 my-div">
                <h4 class="text-center">Latest Expenses</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">To</th>
                        <th class="text-center">Purpose</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($allExpense as $singleExpense){ ?>
                        <tr>
                            <td><?php echo $singleExpense['expenseTo'];?></td>
                            <td><?php echo $singleExpense['expensePurpose'];?></td>
                            <td><?php echo $singleExpense['expenseAmount'];?></td>
                            <td><?php echo $singleExpense['created'];?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <a class="btn btn-info" style="float: right" href="expenses.php">See more...</a>
            </div>
        </div>
        <div class="row" style="margin-top: 2%">
            <div class="col-md-offset-2 col-md-8 col-xs-12 my-div">
                <h4 class="text-center">Latest added products</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Manufacturer</th>
                        <th class="text-center">Pack Size</th>
                        <th class="text-center">Dosage Form</th>
                        <th class="text-center">In stock</th>
                        <th class="text-center">Sale Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($latestProducts as $singleProduct){
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $singleProduct['brandName'];?></td>
                            <td class="text-center"><?php echo $singleProduct['manufacturer'];?></td>
                            <td class="text-center"><?php echo $singleProduct['packSize'];?></td>
                            <td class="text-center"><?php echo $singleProduct['dosageForm'];?></td>
                            <td class="text-center"><?php echo $singleProduct['stockQuantity'];?></td>
                            <td class="text-center"><?php echo $singleProduct['salePrice'];?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <a class="btn btn-info" style="float: right" href="products.php">See more...</a>
            </div>
        </div>
    </div>

<?php include 'footer.php';?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>
