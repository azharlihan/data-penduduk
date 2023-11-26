<?php

class Controller
{
	public $stream;

	public function __construct()
	{
		$this->stream = json_decode(file_get_contents('php://input'));
	}
	public function view($view, $data = [])
	{
		extract($data);

		require "views/$view.php";
	}

	public function model($model)
	{
		require_once "models/$model.php";
		$modelName = "\models\\$model";
		return new $modelName;
	}

	public function response($response)
	{
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function postData($key = null)
	{
		if (is_null($key)) {
			$postData =  filter_input_array(INPUT_POST, FILTER_DEFAULT, true);
			return $postData;
		} else {
			return filter_input(INPUT_POST, $key, FILTER_DEFAULT);
		}
	}

	public function redirect($url)
	{
		header("Location: $url");
		exit();
	}
}
