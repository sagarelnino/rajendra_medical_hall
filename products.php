<?php
require 'session_required.php';
require 'connection.php';
$page = 'products';
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}
$total_records_per_page = 100;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
$total_records = $product->getAllProductsNumber();
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;
$productAll = $product->getAllProductsWithLimit($offset,$total_records_per_page);
#die('died'.'<pre>'.print_r(count($productAll),true));
if(isset($_POST['searchBrand'])){
    $searchField = $_POST['searchField'];
    $len = strlen($searchField);
    $output = '';
    for($i=0;$i<$len;$i++){
        if($searchField[$i] == '('){
            break;
        }
        $output .= $searchField[$i];
    }
    $productAll = $product->getSearchedProducts(trim($output));
}
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
</head>
<style>
    ul.mystyle{
        background-color: #4cae4c;
        cursor: pointer;
    }
    ul .mystyle li{
        padding: 12px;
    }
    .inline{
        display: inline-block;
        float: right;
        margin: 20px 0px;
    }

    input, button{
        height: 34px;
    }
</style>
<body>
<?php include 'admin_navbar.php' ?>
<div class="container-fluid">
    <h2 class="text-center">List of Products</h2>
    <a style="display: block; width: 15%; margin-left: 42%; margin-bottom: 2%" class="btn btn-success text-center" href="add_product.php">Add New Product</a>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
        <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
    </div>
    <div class="row">
        <div class="ool-xs-12 col-md-offset-2 col-md-8" style="margin-bottom: 2%">
            <form class="form-inline" method="post">
                <input type="text" style="width: 80%" class="form-control" name="searchField" id="searchField" placeholder="Enter what to search">
                <div id="searchSuggestion"></div>
                <input type="submit" style="width: 10%" class="btn btn-sm btn-success" name="searchBrand" value="Search">
            </form>
        </div>
    </div>
    <div class="col-xs-12 my-table">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Manufacturer</th>
                <th class="text-center">Pack Size</th>
                <th class="text-center">Dosage Form</th>
                <th class="text-center">In Stock</th>
                <th class="text-center">MRP</th>
                <th class="text-center">Action</th>
                <th class="text-center">Stock</th>
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
                    <?php
                        if($singleProduct['stockQuantity']==0){?>
                            <td class="text-center" style="background-color: #eb9316"><?php echo $singleProduct['stockQuantity'];?></td>
                        <?php }elseif($singleProduct['stockQuantity'] < 0 ){?>
                            <td class="text-center" style="background-color: orangered"><?php echo $singleProduct['stockQuantity'];?></td>
                        <?php }else{?>
                            <td class="text-center" style="background-color: greenyellow"><?php echo $singleProduct['stockQuantity'];?></td>
                        <?php }
                    ?>
                    <td class="text-center"><?php echo $singleProduct['salePrice'];?></td>

                    <td class="text-center"><a href="product_details.php?id=<?php echo $singleProduct['id'];?>" class="btn btn-sm btn-info">Details</a> <a href="edit_product.php?id=<?php echo $singleProduct['id'];?>" class="btn btn-sm btn-primary">Edit</a> <a href="delete_product.php?id=<?php echo $singleProduct['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a></td>
                    <td class="text-center">
                        <form method="post" action="add_stock.php" class="form-inline">
                            <input type="number" name="stockQuantity" min="1">
                            <input type="hidden" name="productId" value="<?php echo $singleProduct['id']?>">
                            <input type="submit" class="btn btn-default" name="submit" value="Add">
                        </form>
                    </td>
                    <!--<td class="text-center">
                        <?php
/*                            if ($singleProduct['isInStock']){
                                echo "You have this";
                                echo "<br>";*/?>
                                <a href="instock_ok.php?id=<?php /*echo $singleProduct['id']*/?>" class="btn btn-success"> Not in stock </a>
                            <?php /*}else{*/?>
                                <a href="instock_change.php?id=<?php /*echo $singleProduct['id']*/?>" class="btn btn-warning">In Stock</a>
                            <?php /*}
                        */?>
                    </td>-->
                </tr>
            <?php } ?>
            </tbody>
        </table>
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
        <!--<div class="inline">
            <input id="pn" type="number" min="1" max="<?php /*echo $total_pages*/?>"
                   placeholder="<?php /*echo $pn."/".$total_pages; */?>" required>
            <button onclick="go2Page();">Go</button>
        </div>-->
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>
<script>
    document.getElementById('searchSuggestion').style.display = 'none';
    $(document).ready(function () {
       $('#searchField').keyup(function () {
            var query = $(this).val();
            if(query != ''){
                $.ajax({
                    url:"product_search.php",
                    method:"POST",
                    data:{query:query},
                    success:function (data) {
                        $('#searchSuggestion').fadeIn();
                        $('#searchSuggestion').html(data);
                    }
                });
            }
        }) ;
       $(document).on('click','li',function () {
          $('#searchField').val($(this).text());
          $('#searchSuggestion').fadeOut();
       });
    });
</script>