<?php
class Controller
{
	public $property = 	1;
	
	public function __construct()
	{
		session_start();	
	}
	
	public function render($template, $data = array()) //$template= footer/header.
	{
	$path = __DIR__ . '/../templates/' . $template.'.php';
	if (file_exists($path))	{
			extract($data);
			require("$path");
							}
	}

}

?>