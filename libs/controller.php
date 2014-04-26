<?php
class Controller
{
	public function __set($key, $value)
	{
		$this -> $key = $value;
	}		
	
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
			$this -> $name = new $name();
			
		}
		else
			{
				$controller = new error('Undefined Model');
				die();
			}
	}
	
	public function lib($name)
	{
		$file = 'libs/' . $name . '.php';
		if (file_exists($file))
		{
			require_once $file;
			$this -> $name = new $name();
		}
		else
			{
				$controller = new error('Undefined Library');
				die();
			}
	}
}
?>