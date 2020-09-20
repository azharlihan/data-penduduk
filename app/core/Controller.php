<?php

class Controller
{
	public function view($view, $data = [])
	{
		extract($data);

		require "views/$view.php";
	}

	public function model($model)
	{
		require_once "models/$model.php";
		$modelName = "\Models\\$model";
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
			$postData =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, true);
			return $postData;
		} else {
			return filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
		}
	}
}
