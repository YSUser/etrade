<?php
class Index extends Controller
{
	public function __construct()
	{
		$this -> view('newview');
	}	
	
	public function test()
	{
		//echo $_SERVER['REQUEST_URI'];
		//echo dirname($_SERVER['SCRIPT_NAME']);
		$this -> view('newview');
		$this -> model('indexModel');
		$this -> model -> temp();
	}
	
	public function optional($arg = NULL)
	{
		echo $arg;
	}
	
}
?>