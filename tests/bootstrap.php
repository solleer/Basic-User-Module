<?php
//Autoloader for User classes
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/UserTest.php';
spl_autoload_register(function($class) {
	$parts = explode('\\', ltrim($class, '\\'));
	if ($parts[0] === 'BasicUser') {
		array_shift($parts);
		require_once 'user/' . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
	}
});
