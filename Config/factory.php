<?php
class factory extends database
{
    private static $factory;
    public static function getFactory()
    {
        if (!self::$factory)
            self::$factory = new ConnectionFactory();
        return self::$factory;
    }

    private $dbh;
	private $errorHandler;

    public function getConnection() {
        if (!$this->dbh)
          $dsn = $this->databaseConfig['DB_TYPE'].':host='.$this->databaseConfig['DB_HOST'].';dbname='.$this->databaseConfig['DB_NAME'];
			try
			{
				$dbh = new PDO($dsn,$this->databaseConfig['DB_USER'],$this->databaseConfig['DB_PASS']);
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