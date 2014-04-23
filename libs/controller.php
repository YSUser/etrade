<?php
class Controller
{
	protected $model;
		
	public function view($name)
	{
		$file = 'views/' . $name . '.php';
		if (file_exists($file))
		{
			require $file;
		}
		else
			{
				$controller = new error('Undefined View');
				die();
			}
	}
	
	public function model($name)
	{
		$file = 'models/' . $name . '.php';
		if (file_exists($file))
		{
			require $file;
			$this -> model = new $name();
			
		}
		else
			{
				$controller = new error('Undefined Model');
				die();
			}
	
	}
}
?>