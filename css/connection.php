<?php
	require 'Model/Admin.php';
	require 'Model/Role.php';
	require 'Model/AdminType.php';
	require 'Model/Product.php';
	require 'Model/Invoice.php';
	try{
		$con=new PDO("mysql:host=localhost;dbname=techxzad_rmh","techxzad_sagar","l0c@lhOst");
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$admin = new Admin($con);
		$role = new Role($con);
		$adminType = new AdminType($con);
		$product = new Product($con);
		$invoice = new Invoice($con);
	}
	catch(PDOException $e)
		{
			 echo $e->getMessage();
		}
?>