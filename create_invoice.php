<?php
require 'session_required.php';
require 'connection.php';
$page = 'create_invoice';
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

</style>
<body>
<?php include 'admin_navbar.php' ?>
<div class="container">
        <div class="col-md-offset-2 col-md-8 my-table">
            <label for="invoice"> Brand Name</label>
            <input type="text" class="form-control" placeholder="Enter Brand Name" id="invoice" name="invoice">
            <div id="searchSuggestion"></div><br>
            <div class="row">
                <div class="col-md-5">
                    <label for="price"> Unit Price</label>
                    <input type="text" class="form-control" placeholder="" id="price" name="price" disabled>
                </div>
                <div class="col-md-offset-2 col-md-5">
                    <label for="quantity">Stock Quantity</label>
                    <input type="number" class="form-control" placeholder="" id="stock_quantity" name="stock_quantity" disabled>
                </div>
            </div>
            <br>
            <label for="quantity">Sale Quantity</label>
            <input type="number" class="form-control" placeholder="" min="1" value="1" id="sale_quantity" name="sale_quantity"><br>
            <div id="taken_loan" style="display:none;">
                <label for="taken_form">Taken From</label>
                <input type="text" class="form-control" placeholder="" id="taken_form" name="taken_form">
            </div><br>
            <div class="my-btn">
                <input type="button" class="btn btn-sm btn-success" id='submit' name="submit" value="ADD TO INVOICE">
            </div>
        </div>

        <div class="col-md-12 my-invoice">
            <table class="table table-bordered" id="table-tr">
                <thead>
                <tr>
                    <th>Brand Name</th>
                    <th>Manufacturer</th>
                    <th>Pack Size</th>
                    <th>Dosage Form</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5">Net Price</th>
                    <th colspan="2" id="net_price">0</th>
                </tr>
                <tr>
                    <th colspan="5">Discount</th>
                    <th colspan="2"><input type="number" id="discount" min="0" value="0"></th>
                </tr>
                <tr>
                    <th colspan="5">Total</th>
                    <th colspan="2" id="total_price">0</th>
                </tr>
                </tfoot>
            </table>
            <button id="final" class="text-right">Submit</button>
        </div>
</div>
<?php include 'footer.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>
<script>
    var loan_data_id=0;
    var total_price=0;
    var net_price=0;
    var all_data=[];
    var id_stock=[];
    var loan_data=[];
    $(document).ready(function () {

        $('#invoice').keyup(function () {
            var query = $(this).val();
            if(query != ''){
                $.ajax({
                    url:"invoice_search.php",
                    method:"POST",
                    data:{query:query},
                    success:function (data) {
                        $('#searchSuggestion').fadeIn();
                        $('#searchSuggestion').html(data);
                    }
                });
            }
            else {
                $('#searchSuggestion').fadeOut();
            }
        }) ;
        $(document).on('click','li',function () {
            $("#taken_loan").hide();
            $("#taken_form").val("");

            id_stock=$(this).attr("id").split("@");
            //console.log(id_stock);
            var text=$(this).text();
            $('#invoice').val(text);
            $("#price").val(text.split("|")[3]);
            $("#stock_quantity").val(id_stock[1]);
            if(id_stock[1]<1)
            {
                $("#taken_loan").show();
            }
            $('#searchSuggestion').fadeOut();
        });
        $("#submit").on("click",function () {
            var add_id="";
            if(id_stock[1]<1)
            {
                taken_form=$("#taken_form").val();
                loan_data.push([taken_form,$("#sale_quantity").val(),id_stock[0]]);
                add_id=loan_data_id;
                loan_data_id+=1;
            }
            var name = $("#invoice").val().split("|");
            var price = $("#price").val();
            var quantity=$("#sale_quantity").val();
            var sub_price=parseFloat(parseInt(quantity)* parseFloat(price,2),2);
            var markup = "<tr id='"+add_id+"'><td>"+name[0]+"</td><td>" +name[4] + "</td><td>" + name[1]+ "</td><td>"+name[2] +"</td><td>"+quantity+"</td><td>"+ sub_price+"</td><td><button class='btn btn-danger'>Delete</button></td></tr>";
            $("table").append(markup);
            all_data.push([name[0],name[4],name[1],name[2],quantity,sub_price,id_stock[0]])
            net_price +=sub_price;
            $('#invoice').val("");
            $("#price").val("");
            $("#stock_quantity").val("");
            $("#sale_quantity").val("");
            $("#sale_quantity").val(1);
            $("#net_price").text(net_price);
            $("#total_price").text(net_price);
            $("#discount").val(0);
        });
        $("#discount").on("change",function () {
            var p=net_price - parseFloat($(this).val());
            $("#total_price").text(p);
    });

    });

    $(document).on("click","button",function (e) {
        var del=$(this).text();
        if(del=="Delete")
        {
            if(confirm("Are you sure delete this item.!"))
            {
                var row=$(this).closest("tr").html().split("</td><td>");
                net_price-=parseFloat(row[5]);
                net_price=parseFloat(net_price,2);
                $("#net_price").text(net_price);
                $("#total_price").text(net_price);
                $("#discount").val(0);
                row_number=$(this).closest("tr").index();
                all_data.splice(row_number,1);
                if($(this).closest("tr").attr("id")!= "")
                {
                    loan_data[$(this).closest("tr").attr("id")]="";
                }
                $(this).closest("tr").remove();
                console.log(all_data);
                console.log(loan_data);
                console.log($(this).closest("tr").attr("id"));
            }
        }
    });
    $(document).on("click","#final",function () {

        loan_data_id=0;
        var dis=$("#discount").val();
        var price=$("#total_price").text();
        $.ajax({
            url:"taken_update.php",
            method:"POST",
            data:{data:loan_data},
            success:function (data) {
                console.log("ok");
            }
        });
        $.ajax({
            url:"invoice_update.php",
            method:"POST",
            data:{data:all_data,discount:dis,price:price},
            success:function (data) {
                console.log(data);
               location.href="invoice_print.php?id="+data+"";
            }
        });
        loan_data=[];
        all_data=[];

    });
</script>