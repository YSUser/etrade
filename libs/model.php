<?php
class Model
{
	protected $db;
	
	public function __construct()
	{
		$this -> getConnection();
	}
	
	private function getConnection()
	{
		$this -> db = Database::getConnection() -> connect();
	}
}
?>