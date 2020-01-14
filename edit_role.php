<?php
require 'session_required.php';
require 'connection.php';
$roleId = $_GET['id'];
if(!$role->isExistRole($roleId)){
    $_SESSION['message'] = 'This Role does not exist';
    header('location:roles.php');
}
$roleInfo = $role->getRoleById($roleId);
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $details = $_POST['details'];
    if(!empty($name)){
        $updated = date('Y-m-d H:i:s');
        $role->updateRole($name,$details,$updated,$roleInfo['id']);
        $logDetails = '';
        if($name != $roleInfo['name']){
            $logDetails .= 'Role name has been changed from '.$roleInfo['name'].' to '.$name;
        }
        if($details != $roleInfo['details']){
            $logDetails .= 'Role details has been changed from '.$roleInfo['details'].' to '.$details;
        }
        if($logDetails){
            $logDetails .= ' changed by '.$_SESSION['adminName'];
            $log->addLog($logDetails,$_SESSION['adminId'],$updated);
        }
        $_SESSION['message'] = 'Successfully Updated';
        header('location:roles.php');
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
    <h4 class="text-center">Edit Role</h4>
    <div class="col-md-offset-2 col-md-8 my-table">
        <form method="POST" onsubmit="return validate()">
            <div class="form-group">
                <label for="email">Role Title</label>
                <input type="text" class="form-control" name="name" id="role-title" value="<?php echo $roleInfo['name']?>" required>
                <span id="error" style="color: orangered">Please Enter Some Value</span>
            </div>
            <div class="form-group">
                <label for="pwd">Description</label>
                <textarea class="form-control" name="details" id="description"><?php echo $roleInfo['details']?></textarea>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Update">
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
    document.getElementById("error").style.display = "none";
    function validate() {
        var roleName = document.getElementById('role-title').value;
        if(roleName.trim() == ""){
            document.getElementById("error").style.display = "block";
            return false;
        }
        return true;
    }
</script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>