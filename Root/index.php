<?php
$path = '../../etrade_secure/config.php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once("../bootstrap.php");

$etrade = new controller();

if (isset($_SESSION['userid']))
	{	
		$etrade->renderLayout('profile');
	}
else
	{
		$etrade->renderLayout('default');
	}
	
?>
