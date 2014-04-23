<?php
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('BASE')) {
	define('BASE', dirname(dirname(__FILE__)));
}
if (!defined('ROOT')) {
	define('ROOT', dirname(__FILE__) . DS);
}

if (!defined('INDEX')) {
	define('INDEX', 'index.php');
}

if (!defined('CORE')) {
	define('CORE', BASE . DS . 'libs');
}

require CORE . DS . 'bootstrap.php';

$app = new Request();
?>
