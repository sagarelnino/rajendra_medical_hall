<?php 
session_start();
if(empty($_SESSION['adminId']) || empty($_SESSION['adminName'])){
	header("location:index.php");
}
?>