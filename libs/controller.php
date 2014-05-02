<?php
class Controller
{
	public function __set($key, $value)
	{
		$this -> $key = $value;
	}		
	
	public function view($name)
	{
		if (is_array($name))
		{
			$file = BASE . DS . 'views' . DS . $name['0'] . DS . $name['1'] . '.php';
		}
		else
			{
				$file = BASE . DS . 'views' . DS . $name . '.php';
			}
			
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
		$file = BASE . DS . 'models' . DS . $name . '.php';
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
		$file = CORE . DS . $name . '.php';
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