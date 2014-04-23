<?php
class Controller
{
	private $root;
	private $dbConnect;
	private $segments = array();
	
	public function __construct()
	{
		$this->root = dirname($_SERVER['PHP_SELF']);
		$this->modelConnect = new Model();
		$this->frontController();
	}
	
	private function frontController()
	{
		//identify url segments
		$uri = $_SERVER['REQUEST_URI'];
		$base = dirname($_SERVER['PHP_SELF']);
		$paths = array_diff_assoc(explode('/',$uri),explode('/',$base));
		//save segments in methods array
		foreach ($paths as $value => $key)
		{
			array_push($this->segments, $key);
		}
	}
	

	
	public function renderTemplate($template, $data = array())
	{
	$path = __DIR__ . '/../Templates/' . $template.'.php';
	if (file_exists($path))	{
			extract($data);
			require("$path");
							}
	}
	
	public function renderLayout($layout)
	{
		$path = __DIR__ . '/../Layout/' . $layout.'.php';
			if (file_exists($path))
			{
				require("$path");
			}


	}
	
	public function goHome()
	{
		header('Location:' . $this->root);
	}
	
	public function deleteAccount($id)
	{
		$this->dbConnect->deleteAccount($id);	
	}
	
	public function returnSomething()
	{
		return 'something';	
	}

}

?>