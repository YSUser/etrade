<?php
class Dispatcher
{
	private $controllerPath;
	private $segments = array();
	
	public function __construct(Request $Request)
	{
		$segments = $Request->getSegments();

		if ($segments[0] == 'index.php' || $segments[0] == '')
		{
			$this->controllerPath = ROOT . '/Controller/indexController.php';
		}
		else
		{
			$controllerPath = ROOT . '/Controller/' . $segments[0] .'Controller.php';
				
			if (file_exists($controllerPath))
				{
					$this->controllerPath = $controllerPath;
				}
				else
				{
					echo 'no file';	
					//throw exception
				}
		}
	}
	
	public static function test()
	{
		include($this->controllerPath);
	}
	
	
}
?>