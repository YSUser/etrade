<?php
class indexModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function temp()
	{
		echo 'sdf';
		$test = $this -> db -> query('SELECT * FROM customers');
		var_dump($test -> fetch(PDO::FETCH_ASSOC));
	}
}
?>