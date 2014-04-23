<?php
class Request
{
	public function __construct()
	{
		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
		{
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}
		elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
		{
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}
		
		$segments = ltrim($uri, '/');
		$segments = explode('/', $segments);
				
		if (empty($segments[0]))
		{
			$segments[0] = 'index';
		}
		
		$file = 'controllers/' . $segments[0] . '.php';
		if (file_exists($file))
		{
			require $file;
		}
		else
			{
				$controller = new error('Undefined Class');
				die();
			}
			
		$controller = new $segments[0];
		
		if (isset($segments[2]))
			{
				$controller -> $segments[1]($segments[2]);
			}
			
		else
			{
				if (isset($segments[1]))
					{
						$controller -> $segments[1]();
					}
			}
	}
}
?>