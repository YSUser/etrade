<?php
class Controller
{
	public $property = 	1;
	public $root;
	
	public function __construct()
	{
		$this->root = dirname($_SERVER['PHP_SELF']);
	}
	
	public function render($template, $data = array()) //$template= footer/header.
	{
	$path = __DIR__ . '/../templates/' . $template.'.php';
	if (file_exists($path))	{
			extract($data);
			require("$path");
							}
	}
	
	public function goHome()
	{
		header('Location:' . $this->root);
	}

}

?>