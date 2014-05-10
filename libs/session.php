<?php
class Session
{
	public function __construct()
	{
		session_start();
	}
	
	public function destroy()
	{
		session_destroy();
	}
	
	public function setData($key, $val)
	{
		$_SESSION[$key] = $val;
	}
	
	public function unsetData($key)
	{
		unset($_SESSION[$key]);
	}
	
	public function getData($key)
	{
		return $_SESSION[$key];
	}
	
	public function getAllData()
	{
		return $_SESSION;
	}
}
?>