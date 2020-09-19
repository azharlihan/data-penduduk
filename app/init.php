<?php

// Change root directory to init.php location
chdir(__DIR__);

// Load the configuration
require_once 'core/Config.php';

// Load the real app class
require_once 'core/App.php';

spl_autoload_register(function ($className) {
	// Make sure backslash replaced with slash when using namespace
	$className = str_replace("\\", "/", $className);

	if (file_exists("core/$className.php")) {
		// For autoload core class that have no namespace
		require_once "core/$className.php";
	} else	if (file_exists("$className.php")) {
		// For autolad another class that have namespace
		require_once "$className.php";
	}
});

// Instantiation app
$app = new App;
