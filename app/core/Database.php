<?php

class Database
{
	private $host = DB_HOST;
	private $dbname = DB_NAME;
	private $user = DB_USER;
	private $pass = DB_PASS;

	private $pdo;
	private $stmt;

	public function __construct()
	{
		$dsn = "mysql:host={$this->host};dbname={$this->dbname}";
		$option = [
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];

		try {
			$this->pdo = new PDO($dsn, $this->user, $this->pass, $option);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function query($query)
	{
		$this->stmt = $this->pdo->prepare($query);
	}

	public function bind($param, $value, $type = null)
	{
		switch (true) {
			case is_int($value):
				$type = PDO::PARAM_INT;
				break;
			case is_bool($value):
				$type = PDO::PARAM_BOOL;
				break;
			case is_null($value):
				$type = PDO::PARAM_NULL;
				break;
			default:
				$type = PDO::PARAM_STR;
				break;
		}

		$this->stmt->bindValue($param, $value, $type);
	}

	public function result()
	{
		$this->stmt->execute();
		return $this->stmt->fetchAll();
	}

	public function row()
	{
		$this->stmt->execute();
		return $this->stmt->fetch();
	}

	public function execute()
	{
		$this->stmt->execute();
		return $this->stmt->rowCount();
	}
}
