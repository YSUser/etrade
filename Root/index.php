<?php
$path = '../../etrade_secure/config.php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require("../bootstrap.php");

$etrade = new controller();

if (isset($_SESSION['userid']))
	{	
		$etrade->render('header',array('title' => 'E-trade Portfolio'));
		$etrade->render('search_view');
		$etrade->render('footer');
	}
else
	{
		$etrade->render('header',array('title' => 'E-trade'));
		$etrade->render('login_view');
		$etrade->render('search_view');
		$etrade->render('footer');
	}
	echo $etrade->fg; echo '<br>';
	echo $_SERVER['PHP_SELF'];
?>
