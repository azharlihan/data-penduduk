<?php

// Change root directory to init.php location
chdir(__DIR__);

// Load the configuration
require_once 'core/Config.php';

// Load the real app class
require_once 'core/App.php';

// Instantiation app
$app = new App;

// Autoload another core class
spl_autoload_register(function ($className) {
	if (file_exists("core/$className.php")) {
		require_once "core/$className.php";
	}
});
