<?php
/* @description     Transformation Style Sheets - Revolutionising PHP templating    *
 * @author          Tom Butler tom@r.je                                             *
 * @copyright       2015 Tom Butler <tom@r.je> | https://r.je/                      *
 * @license         http://www.opensource.org/licenses/bsd-license.php  BSD License *
 * @version         0.9                                                             */
//Autoloader for Vision classes
require_once "Website_Framework_TestCase.php";
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
