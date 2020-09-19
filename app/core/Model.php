<?php

class Model
{
	protected $db;
	protected $table;

	public function __construct()
	{
		$this->db = new Database;
	}
}
