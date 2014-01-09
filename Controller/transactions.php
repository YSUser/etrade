<?php
session_start();
require('../model/model.php');

if (isset($_POST['submit'])) //Sell or Buy Stock
{
	$transactionSymbol=$_POST['symbol'];
	$transactionAmount=$_POST['amount'];
	
	if ($_POST['submit'] == 'Buy')
	{
		$transaction=buy_shares("$transactionSymbol","$transactionAmount");
		$_SESSION['transaction']=$transaction;
		header("location:http://192.168.1.120/etrade/root/portfolio.php");
	}
	if ($_POST['submit'] == 'Sell')
	{
		$transaction=sell_shares("$transactionSymbol","$transactionAmount");
		$_SESSION['transaction']=$transaction;
		header("location:http://192.168.1.120/etrade/root/portfolio.php");
	}
	
}//end Sell or Buy Stock

?>