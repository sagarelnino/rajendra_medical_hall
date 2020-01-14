<?php
require 'session_required.php';
$page = 'expense';
require 'connection.php';
if(isset($_POST['submit'])){
    $expenseTo = filter($_POST['expenseTo']);
    $expensePurpose = filter($_POST['expensePurpose']);
    $expenseAmount = filter($_POST['expenseAmount']);
    if(!empty($expenseTo) && !empty($expenseAmount)){
        $created = date('Y-m-d H:i:s');
        $issuedBy = $_SESSION['adminId'];
        $expense->addExpense($expenseTo,$expensePurpose,$expenseAmount,$issuedBy,$created);
        $_SESSION['message'] = 'Expense Successfully Added';
        header("location:expenses.php");
    }else{
        $_SESSION['message'] = 'Please Enter the required fields';
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
    <h3 class="text-center">Add Expense Details (<span class="mandatory"> * </span> fields are mandatory)</h3>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div class="col-md-offset-2 col-md-8 my-table">
        <form method="POST" onsubmit="return validate()">
            <div class="form-group">
                <label for="expenseTo">To (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="expenseTo" id="expenseTo" placeholder="Enter to whom you are giving" required>
                <span id="expenseToError" style="color: orangered">Please Enter to whom you are giving the money</span>
            </div>
            <div class="form-group">
                <label for="expensePurpose">Purpose</label>
                <textarea class="form-control" name="expensePurpose" id="expensePurpose" placeholder="Enter purpose of expense"></textarea>
            </div>
            <div class="form-group">
                <label for="expenseAmount">Amount (<span class="mandatory"> * </span>)</label>
                <input type="text" class="form-control" name="expenseAmount" id="expenseAmount" placeholder="Enter amount in tk of expense" required>
                <span id="expenseAmountError" style="color: orangered"></span>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Add">
        </form>
    </div>
</div>
<?php include 'footer_fixed.php'; ?>
<script type="text/javascript">
    document.getElementById("expenseToError").style.display = "none";
    function validate() {
        var expenseTo = document.getElementById('expenseTo').value;
        var expenseAmount = document.getElementById('expenseAmount').value;
        if(expenseTo.trim() == ""){
            document.getElementById("expenseToError").style.display = "block";
            document.getElementById('expenseTo').focus();
            return false;
        }
        if(validatePrice(expenseAmount.trim()) === false){
            document.getElementById('expenseAmountError').innerHTML = 'Enter a valid price';
            document.getElementById('expenseAmount').focus();
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