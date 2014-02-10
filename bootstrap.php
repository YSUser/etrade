<?php
$path = 'Config/Config.php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

function autoloader($class)
{
	$file =  ucfirst($class) . '.php';
	$directory = ucfirst($class) . '/';
	$path = __DIR__.'/'. $directory . $file;
	if (file_exists($path))
		{
			include $path;
		}
	else
		{
			//throw exception.. 	
		}
}

spl_autoload_register('autoloader');


?>