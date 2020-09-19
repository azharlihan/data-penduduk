<?php

class BaseController
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
}
