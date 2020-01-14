<?php
require 'session_required.php';
require 'connection.php';
$adminTypeAll = $adminType->getAllAdminTypes();
if(isset($_POST['submit'])){
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $adminTypeTextId = $_POST['adminTypeTextId'][0];
    if(!$admin->isExistAdminByUsername($username)){
        if($adminTypeTextId != 'No'){
            $created = date('Y-m-d H:i:s');
            $admin->addAdmin($fullname,$adminTypeTextId,$username,md5($password),$created);
            $logDetails = 'New admin username '.$username.' of type '.$adminTypeTextId.' has been created by '.$_SESSION['adminName'];
            $log->addLog($logDetails,$_SESSION['adminId'],$created);
            $_SESSION['message'] = 'Successfully added';
            header('location:admins.php');
        }else{
            $_SESSION['message'] = 'Please Select a admin type';
        }
    }else{
        $_SESSION['message'] = 'Already a admin exists with this username';
    }
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
<body>
<?php include 'admin_navbar.php' ?>
<div class="container">
    <h3 class="text-center">Edit Admin</h3>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div class="col-md-offset-2 col-md-8 my-table">
        <form method="POST" onsubmit="return validate()">
            <div class="form-group">
                <label for="email">Full Name</label>
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Enter full name of the admin">
            </div>
            <div class="form-group">
                <label for="pwd">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter a unique username" required>
                <span id="usernameError" style="color: orangered">Please Enter a username</span>
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="text" class="form-control" name="password" id="password" placeholder="Enter a password" required>
            </div>
            <div class="form-group">
                <label for="pwd">Admin Type</label><br>
                <select name="adminTypeTextId[]" class="form-control" id="adminTypeTextId">
                    <option id="nullOption" value="No">Select Admin Type</option>
                    <?php foreach ($adminTypeAll as $singleAdminType){ ?>
                    <option value="<?php echo $singleAdminType['textId']?>"><?php echo $singleAdminType['name'];?></option>
                    <?php } ?>
                </select>
                <span id="typeError" style="color: orangered"></span>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Add">
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
    document.getElementById("usernameError").style.display = "none";
    document.getElementById("passwordError").style.display = "none";
    function validate() {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var adminTypeTextId = document.getElementById('adminTypeTextId').value;
        if(username.trim() == ""){
            document.getElementById("usernameError").style.display = "block";
            return false;
        }
        if(password.trim() == ""){
            document.getElementById("passwordError").style.display = "block";
            document.getElementById('passwordError').innerHTML = 'Please Enter a password';
            return false;
        }
        if(password.length <= 6){
            document.getElementById("passwordError").style.display = "block";
            document.getElementById('passwordError').innerHTML = 'Password should be of more than 6 characters';
            return false;
        }
        if(adminTypeTextId == "No"){
            document.getElementById("typeError").style.display = "Select a admin type";
            return false;
        }
        return true;
    }
</script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>