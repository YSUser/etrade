<?php
class ErrorHandler
{
	public function __construct($errorCode, $errorMessage, $errorFile = NULL, $errorLine = NULL)
	{
		$this -> error($errorMessage, $errorCode);
		set_error_handler($this -> errorTemplate($errorCode, $errorMessage, $errorFile, $errorLine));
	}
		
	private function error($errorCode, $errorMessage)
	{
		switch ($errorCode)
		{
			case 1:
			case 'E_ERROR':
			case 'E_USER_ERROR':
				trigger_error($this -> errorTemplate($errorCode, $errorMessage), E_USER_ERROR);
				break;
			
			case 2:
			case 'E_WARNING':
			case 'E_USER_WARNING':
				trigger_error($this -> errorTemplate($errorCode, $errorMessage), E_USER_WARNING);
				break;
				
			case 3:
			case 'E_NOTICE':
			case 'E_USER_NOTICE':
				trigger_error($this -> errorTemplate($errorCode, $errorMessage), E_USER_NOTICE);
				break;
			
			default:
				break;
		}
	}
	
	private function errorTemplate($errorCode, $errorMessage, $errorFile = NULL, $errorLine = NULL)
	{
		$template = $errorCode . '<br>';
		$template .= $errorMessage . '<br>';
		$template .= $errorFile . '<br>';
		$template .= $errorLine;

		die();
	}
}
?>