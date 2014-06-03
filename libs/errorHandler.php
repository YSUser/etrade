<?php
class errorHandler
{
	private static $error;
	
	private static function constructor($level)
	{
		error_reporting($level);
		set_error_handler(array('ErrorHandler', 'errorTemplate'));
		register_shutdown_function(array('ErrorHandler', 'catchFatal'));
	}
	
    public static function initialize($level = 0)
    {
        if (!self::$error)
		{
			self::constructor($level);
            self::$error = new errorHandler();
		}
        return self::$error;
    }
	
	public static function error($errorMessage, $errorCode)
	{
		switch ($errorCode)
		{
			case 1:
			case 'E_ERROR':
			case 'E_USER_ERROR':
				trigger_error($errorMessage, E_USER_ERROR);
				die();
				break;
			
			case 2:
			case 'E_WARNING':
			case 'E_USER_WARNING':
				trigger_error($errorMessage, E_USER_WARNING);
				break;
				
			case 8:
			case 'E_NOTICE':
			case 'E_USER_NOTICE':
				trigger_error($errorMessage, E_USER_NOTICE);
				break;
			
			default:
				break;
		}
	}
	
	public static function catchFatal()
	{
	    if ($error = error_get_last())
		{
			switch ($error['type'])
			{
				case E_ERROR:
				case E_CORE_ERROR:
				case E_COMPILE_ERROR:
				case E_USER_ERROR:
					self::errorTemplate($error['type'], $error['message'], $error['file'], $error['line']);
					break;
			}
		}

	}
	
	public static function errorTemplate($errorCode, $errorMessage, $errorFile = NULL, $errorLine = NULL)
	{
		$template = '<div style="border:1px solid red; padding-left: 20px; margin-top: 10px;">';
		
		switch ($errorCode)
		{
			case 256:
			case 512:
			case 1024:
				$template .= '<h4>Framework triggered an error</h4>';
				break;
			
			default:
				$template .= '<h4>PHP triggered an error</h4>';
				break;
		}
		$template .= '<p>Error Code: ' . $errorCode . '</p>';
		$template .= '<p>Error Message: ' . $errorMessage . '</p>';
		$template .= '<p>File Path: ' . $errorFile . '</p>';
		$template .= '<p>Line Number: ' . $errorLine . '</p>';
		$template .= '</div>';
		echo $template;
	}

}
?>
