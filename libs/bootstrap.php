<?php
require_once 'config.php';
require_once 'errorHandler.php';

//	autoload this later
errorHandler::initialize();

spl_autoload_register(function ($class) {
    require $class . '.php';
});

?>