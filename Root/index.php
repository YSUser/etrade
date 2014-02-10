<?php
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
