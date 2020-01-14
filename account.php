<?php
require 'session_required.php';
require 'connection.php';
$page = 'account';
$adminInfo = $admin->getAdminById($_SESSION['adminId']);
$adminInfo = $admin->getAdminById($_SESSION['adminId']);
if(isset($_POST['submit'])){
    if($_POST['newPassword'] == $_POST['confirmNewPassword']){
        if($adminInfo['password'] == md5($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['newPassword'];
            $updated = date('Y-m-d H:i:s');
            $admin->updateAdmin($_POST['fullname'],$username,md5($password),$updated,$adminInfo['id']);
            if($username != $adminInfo['username'] || $_POST['fullname'] != $adminInfo['fullname'] || md5($password) != $adminInfo['password']){
                $logDetails = 'Account has been changed of '.$adminInfo['fullname'];
                $log->addLog($logDetails,$_SESSION['adminId'],$created);
            }
            $_SESSION['message'] = 'Successfully Updated';
        }else{
            $_SESSION['message'] = 'Your current password is incorrect';
        }
    }else{
        $_SESSION['message'] = 'The both passwords do not match';
    }
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
<div class="container">
    <h4 class="text-center">Edit Account</h4>
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
                <input type="text" class="form-control" name="fullname" id="username" value="<?php echo $adminInfo['fullname']?>">
            </div>
            <div class="form-group">
                <label for="email">UserName</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo $adminInfo['username']?>">
                <span id="usernameError" style="color: orangered">username can't be blank</span>
            </div>
            <div class="form-group">
                <label for="pwd">Current Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Current Password">
                <span id="passwordError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="pwd">New Password</label>
                <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Enter New Password">
                <span id="newPasswordError" style="color: orangered"></span>
            </div>
            <div class="form-group">
                <label for="pwd">Confirm New Password</label>
                <input type="password" name="confirmNewPassword" class="form-control" id="confirmNewPassword" placeholder="Confirm New Password">
                <span id="confirmNewPasswordError" style="color: orangered"></span>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Update">
        </form>
    </div>
</div>
<?php include 'footer_fixed.php'; ?>
<script type="text/javascript">
    document.getElementById("usernameError").style.display = "none";
    document.getElementById("passwordError").style.display = "none";
    document.getElementById("newPasswordError").style.display = "none";
    document.getElementById("confirmNewPasswordError").style.display = "none";
    function validate() {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var newPassword = document.getElementById('newPassword').value;
        var confirmNewPassword = document.getElementById('confirmNewPassword').value;
        if(username.trim() == ""){
            document.getElementById("usernameError").style.display = "block";
            return false;
        }
        if(password.trim() == ""){
            document.getElementById("passwordError").style.display = "block";
            document.getElementById('passwordError').innerHTML = 'Enter Password Please';
            return false;
        }
        if(newPassword.trim() == ""){
            document.getElementById("newPasswordError").style.display = "block";
            document.getElementById('newPasswordError').innerHTML = 'Enter New Password Please';
            return false;
        }
        if(newPassword != confirmNewPassword){
            document.getElementById("confirmNewPasswordError").style.display = "block";
            document.getElementById('confirmNewPasswordError').innerHTML = 'New Password and confirm password do not match';
            return false;
        }
        if(newPassword.length <= 6){
            document.getElementById("newPasswordError").style.display = "block";
            document.getElementById('newPasswordError').innerHTML = 'Password needs to be more than 6 characters';
            return false;
        }
        return true;
    }
</script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>