<nav class="navbar navbar-inverse my-nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand mine" href="admin.php">Rajendra Medical</a>
        </div>
        <ul style="margin-left: 2%" class="nav navbar-nav">
            <li class="<?php if($page == 'home'){ echo 'active';} ?>"><a href="admin.php">Home</a></li>
            <li class="dropdown <?php if($page == 'products' || $page == 'add_product' || $page == 'loan'){ echo 'active';} ?>">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Products
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if($page == 'products'){ echo 'active';} ?>"><a href="products.php">Products</a></li>
                    <li class="<?php if($page == 'add_products'){ echo 'active';} ?>"><a href="add_product.php">Add Product</a></li>
                    <li class="<?php if($page == 'loan'){ echo 'active';} ?>"><a href="loans.php">Loans</a></li>
                </ul>
            </li>
            <li class="<?php if($page == 'create_invoice'){ echo 'active';} ?>"><a href="create_invoice.php">Create Invoice</a></li>
            <li class="<?php if($page == 'invoice'){ echo 'active';} ?>"><a href="invoices.php">Invoices</a></li>
            <li class="dropdown <?php if($page == 'expense' || $page == 'expenses'){ echo 'active';} ?>">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Expenses<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if($page == 'expense'){ echo 'active';} ?>"><a href="expense.php">Create Expense</a></li>
                    <li class="<?php if($page == 'expenses'){ echo 'active';} ?>"><a href="expenses.php">Expenses</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($page == 'roles' || $page == 'admin_types' || $page == 'admins'){ echo 'active';} ?>">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if($page == 'roles'){ echo 'active';} ?>"><a href="roles.php">Roles</a></li>
                    <li class="<?php if($page == 'admin_types'){ echo 'active';} ?>"><a href="admin_types.php">Admin Type</a></li>
                    <li class="<?php if($page == 'admins'){ echo 'active';} ?>"><a href="admins.php">Admins</a></li>
                </ul>
            </li>
            <li class="<?php if($page == 'logs'){ echo 'active';} ?>"><a href="logs.php">Logs</a></li>
        </ul>
        <ul style="margin-left: 2%" class="nav navbar-nav navbar-right">
        <li class="<?php if($page == 'account'){ echo 'active';} ?>"><a href="account.php">Account</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    </div>
</nav> 