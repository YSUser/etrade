<?php
class Request
{
	private $segments = array();
	
	public function __construct()
	{
		$this->frontController();
	}
	
	private function frontController()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$base = dirname($_SERVER['PHP_SELF']);
		$paths = array_diff_assoc(explode('/',$uri),explode('/',$base));
		foreach ($paths as $value => $key)
		{
			array_push($this->segments, $key);
		}
	}
	
	public function getSegments()
	{
		return $this->segments;	
	}
	
}
?>