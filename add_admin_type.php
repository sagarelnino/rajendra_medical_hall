<?php
require 'session_required.php';
require 'connection.php';
$roles = $role->getAllRoles();
if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $textId = trim($_POST['textId']);
    if(!empty($name) && !empty($textId) && $_POST['roleIdCsv']){
        $roleIdCsv = implode(',',$_POST['roleIdCsv']);
        $created = date('Y-m-d H:i:s');
        $adminType->addAdminType($roleIdCsv,$name,$textId,$created);
        $logDetails = 'New admin type '.$textId.' has been created by '.$_SESSION['adminName'];
        $log->addLog($logDetails,$_SESSION['adminId'],$created);
        $_SESSION['message'] = 'Successfully Added';
        header('location:admin_types.php');
    }else{
        $_SESSION['message'] = 'You need to fill up name and textId and select some roles';
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
    <h3 class="text-center">Add New Admin Type</h3>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div class="col-md-offset-2 col-md-8 my-table">
        <form method="POST" onsubmit="return validate()">
            <div class="form-group">
                <label for="email">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter admin type name" required>
                <span id="nameError" style="color: orangered">Please Enter Some Value</span>
    </div>
            <div class="form-group">
                <label for="pwd">Text Id</label>
                <input type="text" class="form-control" name="textId" id="textId" placeholder="Enter a unique textId" required>
                <span id="textIdError" style="color: orangered">Please Enter Some Value</span>
            </div>
            <div class="form-group">
                <label for="pwd">Roles</label><br>
                <?php foreach ($roles as $singleRole){ ?>
                <label class="checkbox-inline">
                    <input type="checkbox" value="<?php echo $singleRole['id']?>" name="roleIdCsv[]"><?php echo $singleRole['name']?>
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
    document.getElementById("textIdError").style.display = "none";
    function validate() {
        var name = document.getElementById('name').value;
        var textId = document.getElementById('textId').value;
        if(name.trim() == ""){
            document.getElementById("nameError").style.display = "block";
            return false;
        }
        if(textId.trim() == ""){
            document.getElementById("textIdError").style.display = "block";
            return false;
        }
        return true;
    }
</script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>