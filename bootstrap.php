<?php
define ('ROOT' , dirname(__FILE__));
$path = ROOT . '/Config';

set_include_path(get_include_path() . PATH_SEPARATOR . $path);

include('Dispatch.php');
include('Request.php');

spl_autoload_register(array('Dispatcher', 'test'));

?>