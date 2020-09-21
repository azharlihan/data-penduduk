<?php

class Datatables
{
	public $postData;

	public $selectColumn;

	public $from;

	public $join;

	public $searchColumn;

	protected $db;

	protected $searchQuery;

	protected $query;

	public function __construct()
	{
		$this->selectColumn = '*';
		$this->db = new \Database;
	}

	/**
	 * This function changes each column to query 'WHERE like'
	 * ex: where nama like '%agus%'
	 */
	public function generateSearchQuery(array $searchColumn)
	{
		$searchQuery = "";

		if ($this->postData['search']['value'] != '') {
			$count = count($searchColumn) - 1;

			$searchQuery = '(';

			foreach ($searchColumn as $k => $v) {
				$searchQuery .= "$v LIKE :searchValue";

				if ($k < $count) $searchQuery .= ' or ';
			}
			$searchQuery .= ')';
		}

		$this->searchQuery = $searchQuery;
	}

	public function getResult()
	{
		$this->generateSearchQuery($this->searchColumn);

		// Read request value
		$draw = $this->postData['draw'];
		$start = $this->postData['start'];
		$rowPerPage = $this->postData['length']; // Rows display per page
		$columnIndex = $this->postData['order'][0]['column'];
		$columnName = $this->postData['columns'][$columnIndex]['data'];
		$columnSortOrder = $this->postData['order'][0]['dir'];
		$searchValue = $this->postData['search']['value'];

		// Manual sanitizing for variable that doesn't support prepared
		$columnName = preg_replace("/[^\w]/", "", $columnName);
		$columnSortOrder = strtolower($columnSortOrder) == 'desc' ? 'desc' : 'asc';

		// Total number of records without filtering
		$this->query = "SELECT COUNT(*) AS allcount FROM $this->from";
		if (isset($this->join)) {
			$this->query .= " $this->join";
		}

		$this->db->query($this->query);
		$totalRecords = $this->db->row()['allcount'];

		// Total number of record with filtering
		$this->query = "SELECT COUNT(*) AS allcount FROM $this->from";
		if (isset($this->join)) {
			$this->query .= " $this->join";
		}

		if ($this->searchQuery != '') {
			$this->query .= " WHERE $this->searchQuery";
			$this->db->query($this->query);
			$this->db->bind('searchValue', "%$searchValue%");
		} else {
			$this->db->query($this->query);
		}

		$totalRecordwithFilter = $this->db->row()['allcount'];

		// Fetch records
		$this->query = "SELECT $this->selectColumn FROM $this->from";
		if (isset($this->join)) {
			$this->query .= " $this->join";
		}
		if ($this->searchQuery != '') {
			$this->query .= " WHERE $this->searchQuery";
		}

		// single column ordering
		$this->query .= " ORDER BY $columnName $columnSortOrder";
		$this->query .= " LIMIT :start, :rowPerPage";

		$this->db->query($this->query);

		if ($this->searchQuery != '') {
			$this->db->bind('searchValue', "%$searchValue%");
		}
		$this->db->bind('rowPerPage', intval($rowPerPage));
		$this->db->bind('start', intval($start));

		$aaData = $this->db->result();

		// Response
		$result = array(
			'aaData' => $aaData,
			'draw' => intval($draw),
			'iTotalRecords' => $totalRecords,
			'iTotalDisplayRecords' => $totalRecordwithFilter
		);

		return $result;
	}
}
