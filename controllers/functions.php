<?php
function render($template, $data = array()) //$template= footer/header.
	{
	$path = __DIR__ . '/../templates/' . $template.'.php';
	if (file_exists($path))	{
			extract($data);
			require("$path");
							}
	}


?>