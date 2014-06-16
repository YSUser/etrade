<?php
require_once 'config.php';

//	Autoload classes for the rest of the framework
spl_autoload_register(function ($class) {
    require $class . '.php';
});

// Initialize error handling
errorHandler::initialize();

?>