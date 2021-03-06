<?php
require 'session_required.php';
require 'connection.php';
$page = 'invoice';
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}
$total_records_per_page = 50;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
$total_records = $invoice->getAllInvoicesNumber();
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;
$invoices = $invoice->getAllInvoicesWithLimit($offset,$total_records_per_page);
#$invoices = $invoice->getAllInvoices();
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
<div class="container">
    <h2 class="text-center">Invoice List</h2>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <?php
        if(empty($invoices)){
            echo "<p class='text-center'>There is no item in the list</p>";
        }else{?>
            <div class="col-md-offset-2 col-md-8 my-table">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Pricing</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($invoices as $singleInvoice){ ?>
                        <tr>
                            <td class="text-center">
                                <?php
                                $userDetails = $admin->getAdminById($singleInvoice['userId']);
                                echo $userDetails['fullname'];
                                ?>
                            </td>
                            <td class="text-center"><?php echo $singleInvoice['created'];?></td>
                            <td class="text-center">Net Price: <?php echo $singleInvoice['netPrice']?><br>Discount: <?php echo $singleInvoice['discount']?><br>Total: <?php echo $singleInvoice['total']?><br></td>
                            <td><a href="invoice_print.php?id=<?php echo $singleInvoice['id'];?>" class="btn btn-info">View</a> </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php }
    ?>
    <div class="row">
        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
            <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>

        <ul class="pagination text-center" style="margin-left: 30%">
            <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>

            <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
                <a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
            </li>

            <?php
            if ($total_no_of_pages <= 10){
                for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                    if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                    }else{
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                    }
                }
            }
            elseif($total_no_of_pages > 10){

                if($page_no <= 4) {
                    for ($counter = 1; $counter < 8; $counter++){
                        if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";
                        }else{
                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        }
                    }
                    echo "<li><a>...</a></li>";
                    echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                    echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                }

                elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                    echo "<li><a href='?page_no=1'>1</a></li>";
                    echo "<li><a href='?page_no=2'>2</a></li>";
                    echo "<li><a>...</a></li>";
                    for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                        if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";
                        }else{
                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        }
                    }
                    echo "<li><a>...</a></li>";
                    echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                    echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                }

                else {
                    echo "<li><a href='?page_no=1'>1</a></li>";
                    echo "<li><a href='?page_no=2'>2</a></li>";
                    echo "<li><a>...</a></li>";

                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                        if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";
                        }else{
                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        }
                    }
                }
            }
            ?>

            <li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
                <a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
            </li>
            <?php if($page_no < $total_no_of_pages){
                echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
            } ?>
        </ul>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>