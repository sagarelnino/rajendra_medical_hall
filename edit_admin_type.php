<?php
require 'session_required.php';
require 'connection.php';
$roles = $role->getAllRoles();
if(!$adminType->isExistAdminType($_GET['textId'])){
    $_SESSION['message'] = 'No Such admin exists';
    header('location:admin_types.php');
}
$adminTypeDetails = $adminType->getadminTypeByTextId($_GET['textId']);
if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    if(!empty($name) && $_POST['roleIdCsv']){
        $roleIdCsv = implode(',',$_POST['roleIdCsv']);
        $updated = date('Y-m-d H:i:s');
        $adminType->updateAdminType($roleIdCsv,$name,$updated,$adminTypeDetails['textId']);
        if($roleIdCsv != $adminTypeDetails['roleIdCsv']){
            $logDetails = 'Admin type '.$adminTypeDetails['textId'].' is updated by'.$_SESSION['adminName'];
            $log->addLog($logDetails,$_SESSION['adminId'],$updated);
        }
        $_SESSION['message'] = 'Successfully Updated';
        header('location:admin_types.php');
    }else{
        $_SESSION['message'] = 'You need to fill up name and select some roles';
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
    <h3 class="text-center">Edit Admin Type</h3>
    <div class="col-md-offset-2 col-md-8 my-table">
        <form method="POST" onsubmit="return validate()">
            <div class="form-group">
                <label for="email">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $adminTypeDetails['name']?>" required>
                <span id="nameError" style="color: orangered">Please Enter Some Value</span>
            </div>
            <div class="form-group">
                <label for="pwd">Roles</label><br>
                <?php foreach ($roles as $singleRole){ ?>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="<?php echo $singleRole['id']?>"<?php
                        if(strpos($adminTypeDetails['roleIdCsv'],$singleRole['id']) !== false)
                        {
                            echo 'checked';
                        } ?>
                        name="roleIdCsv[]"><?php echo $singleRole['name']?>
                    </label>
                <?php } ?>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Add">
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
    document.getElementById("nameError").style.display = "none";
    function validate() {
        var name = document.getElementById('name').value;
        if(name.trim() == ""){
            document.getElementById("nameError").style.display = "block";
            return false;
        }
        return true;
    }
</script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>