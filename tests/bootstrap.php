<?php
//Autoloader for User classes
spl_autoload_register(function($class) {
	$parts = explode('\\', ltrim($class, '\\'));
	if ($parts[0] === 'User') {
		array_shift($parts);
		require_once 'user/' . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
	}
	else if (file_exists('tests/deps/' . implode(DIRECTORY_SEPARATOR, $parts) . '.php')) {
		include_once 'tests/deps/' . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
	}
});
