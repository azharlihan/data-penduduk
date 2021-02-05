<?php

class Model
{
	protected $db;
	protected $table;
	public $db_prefix = DB_PREFIX;

	public function __construct()
	{
		$this->db = new Database;
	}
}
