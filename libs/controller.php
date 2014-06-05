<?php
class Controller
{
	public function __set($key, $value)
	{
		$this -> $key = $value;
	}		
	
	public function view($name, $data = NULL)
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
			if (is_array($data))
			{
				extract($data);
			}
			require $file;
		}
		else
			{
				errorHandler::error('Undefined View', 'E_WARNING');
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
				errorHandler::error('Undefined Model', 'E_WARNING');
			}
	}
	
	public function lib($name, $vars = array())
	{
		$file = CORE . DS . $name . '.php';
		if (file_exists($file))
		{
			require_once $file;
			if (!empty($vars))
			{
				$this -> $name = new $name($vars);
			}
			else
			{
				$this -> $name = new $name();
			}
		}
		else
		{
			errorHandler::error('Undefined Library', 'E_WARNING');
		}
	}
}
?>