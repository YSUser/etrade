<?php
class Controller
{
	public $property = 	1;
	public $fg;
	
	public function __construct()
	{
		session_start();
		$this->fg = dirname($_SERVER['PHP_SELF']);
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