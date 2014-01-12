<?php
session_start();
require("../controller/functions.php");
require("../controller/yahoo_connect.php");


if (isset($_SESSION['userid']))
	{	
		render('header',array('title' => 'E-trade Portfolio'));
		render('search_view');
		render('footer');
	}
else
	{
		render('header',array('title' => 'E-trade'));
		render('login_view');
		render('search_view');
		render('footer');
	}
?>
