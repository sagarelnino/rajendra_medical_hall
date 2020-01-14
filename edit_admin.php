<?php
require 'session_required.php';
require 'connection.php';
$adminTypeAll = $adminType->getAllAdminTypes();
$adminInfo = $admin->getAdminById($_GET['id']);
if(isset($_POST['submit'])){
    $fullname = trim($_POST['fullname']);
    $adminTypeTextId = $_POST['adminTypeTextId'][0];
    if($adminTypeTextId != 'No'){
        $updated = date('Y-m-d H:i:s');
        $logDetails = '';
        $admin->updateAdminByAdmin($fullname,$adminTypeTextId,$updated,$adminInfo['id']);
        if($adminInfo['fullname'] != $fullname){
            $logDetails .= 'Name changed from '.$adminInfo['fullname'].' to '.$fullname;
        }
        if($adminInfo['adminTypeTextId'] != $adminTypeTextId){
            $logDetails .= 'AdminTypeTextId changed from '.$adminInfo['adminTypeTextId'].' to '.$adminTypeTextId;
        }
        if($logDetails){
            $logDetails .= ' changed by '.$_SESSION['adminName'];
            $log->addLog($logDetails,$_SESSION['adminName'],$updated);
        }
        $_SESSION['message'] = 'Successfully updated';
        header('location:admins.php');
    }else{
        $_SESSION['message'] = 'Please select a admin type';
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
    <h3 class="text-center">Add New Admin</h3>
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
                <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $adminInfo['fullname']?>">
            </div>
            <div class="form-group">
                <label for="pwd">Admin Type</label><br>
                <select name="adminTypeTextId[]" class="form-control" id="adminTypeTextId">
                    <option value="<?php echo $adminInfo['adminTypeTextId']?>"><?php echo $adminType->getAdminTypeNameByTextId($adminInfo['adminTypeTextId']);?></option>
                    <?php foreach ($adminTypeAll as $singleAdminType){ ?>
                        <option value="<?php echo $singleAdminType['textId']?>"><?php echo $singleAdminType['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Update">
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
</script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>