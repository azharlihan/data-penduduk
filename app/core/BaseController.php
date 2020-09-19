<?php

class BaseController
{
	public function view($view, $data = [])
	{
		extract($data);

		require "views/$view.php";
	}
}
