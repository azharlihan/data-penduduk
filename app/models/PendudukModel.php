<?php

class PendudukModel extends BaseModel
{
	protected $table;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'data_penduduk';
	}

	public function getDaftarPenduduk()
	{
		$this->db->query("SELECT * FROM $this->table");
		return $this->db->result();
	}
}
