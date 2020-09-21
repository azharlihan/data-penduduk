<?php

namespace Models;

class Penduduk extends \Model
{
	protected $table;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'data_penduduk';
	}

	public function getDaftarPenduduk($postData)
	{
		$datatable = new \Datatables;

		$datatable->postData = $postData;
		$datatable->from = $this->table;
		$datatable->join = 'INNER JOIN hubungan_keluarga USING(id_stat_hbkel)';
		$datatable->searchColumn = [
			'no_kk',
			'nik',
			'nama_lengkap'
		];

		$daftarPenduduk = $datatable->getResult();

		foreach ($daftarPenduduk['aaData'] as $k => $v) {
			$infoNik = $this->extractInfoNik($v['nik']);
			$daftarPenduduk['aaData'][$k] = array_merge($daftarPenduduk['aaData'][$k], $infoNik);
		}

		return $daftarPenduduk;
	}

	public function postDataPenduduk($postData)
	{
		$now = date('Y-m-d H:i:s');

		$query = "
			INSERT INTO $this->table
			(no_kk, nik, nama_lengkap, id_stat_hbkel, no_rt, tanggal_create, tanggal_update)
			VALUES (:no_kk, :nik, :nama_lengkap, :id_stat_hbkel, 1, \"$now\", \"$now\")
		";

		$this->db->query($query);

		$this->db->bind('no_kk', $postData->no_kk);
		$this->db->bind('nik', $postData->nik);
		$this->db->bind('nama_lengkap', strtoupper($postData->nama_lengkap));
		$this->db->bind('id_stat_hbkel', $postData->id_stat_hbkel);
		$this->db->execute();
		return [
			'status' => 'ok',
			'message' => 'Data Penduduk berhasil di simpan.'
		];
	}

	public function putDataPenduduk($postData)
	{
		$now = date('Y-m-d H:i:s');

		$query = "
			UPDATE $this->table
			SET no_kk = :no_kk, nik = :nik, nama_lengkap = :nama_lengkap, id_stat_hbkel = :id_stat_hbkel, tanggal_update = \"$now\"
			WHERE nik = :old_nik
		";

		$this->db->query($query);

		$this->db->bind('no_kk', $postData->no_kk);
		$this->db->bind('nik', $postData->nik);
		$this->db->bind('old_nik', $postData->old_nik);
		$this->db->bind('nama_lengkap', strtoupper($postData->nama_lengkap));
		$this->db->bind('id_stat_hbkel', $postData->id_stat_hbkel);
		$this->db->execute();
		return [
			'status' => 'ok',
			'message' => 'Data penduduk berhasil di perbarui.'
		];
	}

	public function deleteDataPenduduk($nik)
	{
		$this->db->query("DELETE FROM $this->table WHERE nik = :nik");
		$this->db->bind('nik', $nik);
		$affected = $this->db->execute();
		if ($affected > 0) {
			return [
				'status' => 'ok',
				'message' => 'Data penduduk berhasil dihapus.'
			];
		} else {
			return [
				'status' => 'ok',
				'message' => 'Data penduduk gagal dihapus.'
			];
		}
	}

	public function getDaftarHbkel()
	{
		$this->db->query('SELECT * FROM hubungan_keluarga');
		return $this->db->result();
	}

	public function getDetailPenduduk($nik)
	{
		$this->db->query("SELECT * FROM $this->table WHERE nik = :nik");
		$this->db->bind('nik', $nik);
		return $this->db->row();
	}

	public function checkNIK($nik)
	{
		// Check NIK duplicate
		$this->db->query("SELECT COUNT(nik) as count FROM $this->table WHERE nik = :nik");
		$this->db->bind('nik', $nik);
		return $this->db->row()['count'];
	}

	private function extractInfoNik($nik)
	{
		$birthCode = substr($nik, 6, 6);

		// Determine birthdate and gender
		if ($birthCode > 400000) {
			$gender = 'Perempuan';
			$birthDate = str_pad(substr($birthCode, 0, 2) - 40, 2, '0', STR_PAD_LEFT) . substr($birthCode, 2);
		} else {
			$gender = 'Laki-Laki';
			$birthDate = $birthCode;
		}

		// This if block below for override php default behavior for handling 2 digits year number
		// Default range is 1970-2069. And will change to 1945-2044
		if (substr($birthDate, 4) < 45) {
			$birthDate = substr($birthDate, 0, 4) . '20' . substr($birthDate, 4);
		} else {
			$birthDate = substr($birthDate, 0, 4) . '19' . substr($birthDate, 4);
		}

		$birthDate = \DateTime::createFromFormat('dmY', $birthDate);

		$age = $birthDate->diff(new \DateTime)->format('%y');

		return [
			'gender' => $gender,
			'birth_date' => $birthDate->format('Y-m-d'),
			'age' => $age
		];
	}
}
