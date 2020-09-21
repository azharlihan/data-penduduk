<?php

class App
{
	// Declare properties and intialize default value for each variable
	private $controller = 'Penduduk';
	private $method = 'index';
	private $params = [];


	public function __construct()
	{
		$url = $this->parseURL();

		// Set controller name based URL
		if (isset($url[0])) {
			if (file_exists('controllers/' . $url[0] . '.php')) {
				$this->controller = ucfirst(strtolower($url[0]));
				unset($url[0]);
			} else {
				http_response_code(404);
				exit('<h1>404 Not Found</h1>');
			}
		}
		// Initialize  controller
		$controllerName = "Controllers\\$this->controller";
		$this->controller = new $controllerName;

		// Set method name based URL
		if (isset($url[1])) {
			if (method_exists($this->controller, $url[1])) {
				$this->method = strtolower($url[1]);
				unset($url[1]);
			} else {
				http_response_code(404);
				exit('<h1>404 Not Found</h1>');
			}
		}

		// Set params
		if (!empty($url)) {
			$this->params = array_values($url);
		}

		// Run the method
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	// Parsing to get pretty URL
	public function parseURL()
	{
		if (isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url;
		}
	}
}
