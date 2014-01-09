<?php
session_start();
require('../controller/functions.php');
require("../controller/yahoo_connect.php");

	if (isset($_SESSION['auth']) && ($_SESSION['auth']) == true)
	{
			render('header', array( "title" => 'E-trade Portfolio'));
			render('portfolio_view', array("user" => $_SESSION['username']));
			render('transaction_view');
			render('search_view');
			render('footer');
	}
	else
	{	
			render('header',array('title' => 'E-trade'));
			render('login_view');
			render('register_view');
			render('search_view');
			render('footer');
	}

?>