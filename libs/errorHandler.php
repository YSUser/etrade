<?php
class ErrorHandler extends Exception
{
	public function __construct($message, $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		
		$this -> checkSeverity($message, $code);
		
	}
	
	private function checkSeverity($message, $severity)
	{
		if ($severity == 5)
		{
			exit($message);
		}
	}
	
	public function __toString()
	{
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
?>