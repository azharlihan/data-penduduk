<?php

namespace Controllers;

class Penduduk extends \Controller
{
	public function index()
	{
		$this->view('daftarPenduduk');
	}

	public function form($type = null, $nik = '0')
	{
		$daftarHbkel = $this->model('Penduduk')->getDaftarHbkel();

		$checkNik = $this->model('Penduduk')->checkNik($nik);

		if ($type == 'tambah') {
			$submitText = 'Simpan';
			$detailPenduduk = null;
		} else if ($type == 'perbarui') {
			// Check nik
			if ($checkNik == 0) {
				$this->redirect(BASEURL);
				exit();
			}
			$detailPenduduk = $this->model('Penduduk')->getDetailPenduduk($nik);
			$submitText = 'Perbarui';
		} else {
			$this->redirect(BASEURL . '/penduduk/form/tambah');
		}
		$this->view('formPenduduk', [
			'daftarHbkel' => $daftarHbkel,
			'type' => ucfirst($type),
			'submitText' =>  $submitText,
			'detailPenduduk' => $detailPenduduk,
		]);
	}

	public function getdaftarpenduduk()
	{
		$daftarPenduduk = $this->model('Penduduk')->getDaftarPenduduk($this->postData());

		$this->response($daftarPenduduk);
	}

	public function postdatapenduduk()
	{
		$checkNik = $this->model('Penduduk')->checkNik($this->stream->nik);

		if ($checkNik > 0) {
			$this->response([
				'status' => 'fail',
				'message' => 'NIK yang sama sudah terdaftar.',
			]);
			exit();
		}

		$validation = $this->validateDataPenduduk($this->stream);

		if ($validation === true) {
			$result = $this->model('Penduduk')->postDataPenduduk($this->stream);
			$this->response($result);
		} else {
			$this->response([
				'status' => 'fail',
				'message' => $validation,
			]);
		}
	}

	public function putdatapenduduk()
	{
		$validation = $this->validateDataPenduduk($this->stream);

		if ($validation === true) {
			$result = $this->model('Penduduk')->putDataPenduduk($this->stream);
			$this->response($result);
		} else {
			$this->response([
				'status' => 'fail',
				'message' => $validation,
			]);
		}
	}

	public function delete($nik)
	{
		$result = $this->model('Penduduk')->deleteDataPenduduk($nik);

		$this->response($result);
	}

	// Untuk proses validasi di sisi server
	private function validateDataPenduduk($d)
	{
		if (strlen($d->no_kk) != 16) return 'Nomor KK harus 16 digit';
		if (preg_match("/[^\d]/", $d->no_kk)) return 'Nomor KK hanya bisa berisi digit angka';

		if (strlen($d->nik) != 16) return 'NIK harus 16 digit';
		if (preg_match("/[^\d]/", $d->no_kk)) return 'NIK hanya bisa berisi digit angka';

		if (strlen($d->nama_lengkap) == 0) return 'Nama tidak boleh kosong';
		if (strlen($d->nama_lengkap) > 99) return 'Nama maksimal 99 karakter';
		if (preg_match('/[^A-z ]/', $d->nama_lengkap)) return 'Nama hanya boleh mengandung huruf dan spasi';

		if (strlen($d->id_stat_hbkel) == 0) return 'Harap isi status hubungan keluarga';
		$infoNik = $this->model('Penduduk')->extractInfoNik($d->nik);
		if ($infoNik['gender'] == 'Perempuan') {
			if ($d->id_stat_hbkel == 2) return 'Jenis kelamin perempuan tidak bisa menjadi suami.';
		} else {
			if ($d->id_stat_hbkel == 3) return 'Jenis kelamin laki-laki tidak bisa menjadi istri.';
		}

		return true;
	}
}
