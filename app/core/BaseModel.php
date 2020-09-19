<?php 

class BaseModel
{
	protected $db;
	protected $table; 

	public function __construct()
	{
		$this->db = new Database;
	}
}
