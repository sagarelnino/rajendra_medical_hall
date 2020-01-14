<?php
require 'session_required.php';
require 'connection.php';
$page = 'admin_types';
$adminTypeAll = $adminType->getAllAdminTypes();
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
    <h2 class="text-center">Manage Admin Types</h2>
    <a style="display: block; width: 15%; margin-left: 42%; margin-bottom: 2%" class="btn btn-success text-center" href="add_admin_type.php">Add Admin Type</a>
    <?php
    if(!empty($_SESSION['message'])){?>
        <h3 style="color: red" class="text-center"><?php echo $_SESSION['message']?></h3>
    <?php }
    unset($_SESSION['message']);
    ?>
    <div class="col-md-offset-2 col-md-8 my-table">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Roles</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($adminTypeAll as $adminTypeSingle){ ?>
                <tr>
                    <td class="text-center"><?php echo $adminTypeSingle['name'];?></td>
                    <td class="text-center">
                        <?php
                            $rolesArray = $adminType->rolesArrayFromRoleIdCsv($adminTypeSingle['roleIdCsv'],$role);
                            foreach ($rolesArray as $roles){
                                echo $roles;
                                echo "<br>";
                            }
                        ?>
                    </td>
                    <td class="text-center"><a href="edit_admin_type.php?textId=<?php echo $adminTypeSingle['textId'];?>" class="btn btn-primary">Edit</a> <a href="delete_admin_type.php?textId=<?php echo $adminTypeSingle['textId'];?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer_fixed.php'; ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3/js/bootstrap.min.js"></script>
</body>
</html>