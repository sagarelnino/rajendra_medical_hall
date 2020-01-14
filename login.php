<?php
	session_start();
	require 'connection.php';
	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['userPassword'];
		if($admin->isExistAdmin($username,md5($password))){
			$adminInfo = $admin->getAdminByUsernameAndPassword($username,md5($password));
			$_SESSION['adminId'] = $adminInfo['id'];
			$_SESSION['adminName'] = $adminInfo['fullname'];
			header('location:admin.php');
		}else{
			die("does not exist");
		}	}
?>