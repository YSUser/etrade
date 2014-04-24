<?php
class Database
{
	private $DB_TYPE = 'mysql';
	private $DB_HOST = 'localhost';
	private $DB_NAME = 'test';
	private $DB_USER = 'root';
	private $DB_PASS = 'mypass';
	
    private static $connect;
    public static function getConnection()
    {
        if (!self::$connect)
            self::$connect = new Database();
        return self::$connect;
    }

    private $dbh;
	private $errorHandler;

    public function connect() {
        if (!$this->dbh)
          $dsn = $this -> DB_TYPE . ':host=' . $this -> DB_HOST . ';dbname=' . $this -> DB_NAME;
			try
			{
				$dbh = new PDO($dsn, $this -> DB_USER, $this -> DB_PASS);
				$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
			}
			catch (PDOException $e)
			{
				$this->errorHandler = $e;
				exit($e);	
			}
			catch (PDOException $e)
			{
				$this->errorHandler = $e;
				exit($e);	
			}
        return $dbh;
    }
}
?>