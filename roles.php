<?php
    require 'session_required.php';
    require 'connection.php';
    $page = 'roles';
    $roles = $role->getAllRoles();
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
        <h2 class="text-center">Manage Roles</h2>
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
                    <th class="text-center">Details</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($roles as $role){ ?>
                <tr>
                    <td><?php echo $role['name'];?></td>
                    <td><?php echo $role['details'];?></td>
                    <td><a href="edit_role.php?id=<?php echo $role['id'];?>" class="btn btn-info">Edit</a> </td>
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