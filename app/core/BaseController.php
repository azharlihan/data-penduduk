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
		return new $model;
	}
}
