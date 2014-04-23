<?php
session_start();
include('../Model/model.php');

if (!empty($_POST['username']) && !empty($_POST['password'])) //Check for both username and password entries
{

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

$login=login_user($username,$password);
$_SESSION['login']=$login;
header("location:http://192.168.1.120/etrade/root/portfolio");

}
else
{
	$login='Please provide username and password';
	$_SESSION['login']=$login;
	header("location:http://192.168.1.120/etrade/root/portfolio");
}

?>