<?php
session_start();
include('../model/model.php');

if (!empty($_POST['username']) && !empty($_POST['password'])) //Check for both username and password entries
{
	$username=htmlspecialchars($_POST['username']);
	$password=htmlspecialchars($_POST['password']);
	
	$register=register_user($username,$password);
	if ($register == true)
	{
	$_SESSION['register']=$register;
	header("location:http://192.168.1.120/etrade/root/portfolio");
	}
	else
	{
			$_SESSION['register']=$register;
			header("location:http://192.168.1.120/etrade/root/portfolio");
	}

}
else
{
	$register='Please provide username and password';
	$_SESSION['register']=$register;
	header("location:http://192.168.1.120/etrade/root/portfolio");
}
?>