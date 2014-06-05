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
		$backtrace = self::backtrace();
		
		switch ($errorCode)
		{
			case 1:
			case 'E_ERROR':
			case 'E_USER_ERROR':
				trigger_error($backtrace, E_USER_ERROR);
				die();
				break;
			
			case 2:
			case 'E_WARNING':
			case 'E_USER_WARNING':
				trigger_error($backtrace, E_USER_WARNING);
				break;
				
			case 8:
			case 'E_NOTICE':
			case 'E_USER_NOTICE':
				trigger_error($backtrace, E_USER_NOTICE);
				break;
			
			default:
				break;
		}
	}
	
	private static function backtrace()
	{
		$backtrace = debug_backtrace();
		$backtraceMessage = $backtrace[1]['args'][0] . ',';
		$backtraceMessage .= $backtrace[1]['args'][1] . ',';
		$backtraceMessage .= $backtrace[1]['file'] . ',';
		$backtraceMessage .= $backtrace[1]['line'];
		return $backtraceMessage;
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
				$backtrace = explode(',', $errorMessage);
				$template .= '<h4>Framework triggered an error</h4>';
				$template .= '<p>Error Code: ' . $backtrace[1] . '</p>';
				$template .= '<p>Error Message: ' . $backtrace[0] . '</p>';
				$template .= '<p>File Path: ' . $backtrace[2] . '</p>';
				$template .= '<p>Line Number: ' . $backtrace[3] . '</p>';
				break;
			
			default:
				$template .= '<h4>PHP triggered an error</h4>';
				$template .= '<p>Error Code: ' . $errorCode . '</p>';
				$template .= '<p>Error Message: ' . $errorMessage . '</p>';
				$template .= '<p>File Path: ' . $errorFile . '</p>';
				$template .= '<p>Line Number: ' . $errorLine . '</p>';
				break;
		}

		$template .= '</div>';
		echo $template;
	}

}
?>
