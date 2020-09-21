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
		$validation = $this->validateDataPenduduk($this->stream);

		if ($validation === true) {
			$result = $this->model('Penduduk')->postDataPenduduk($this->stream);
			$this->response($result);
		} else {
			return [
				'status' => 'fail',
				'message' => $validation,
			];
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
		if (strlen($d->no_kk == 0) && strlen($d->no_kk > 16)) return 'Nomor KK harus 16 digit';
		if (strlen($d->no_kk == 0) && strlen($d->no_kk > 16)) return 'NIK harus 16 digit';
		if (strlen($d->nama_lengkap) == 0) return 'Nama tidak boleh kosong';
		if (strlen($d->nama_lengkap) > 100) return 'Nama maksimal 100 karakter';
		if (strlen($d->id_stat_hbkel) == 0) return 'Harap isi status hubungan keluarga';

		return true;
	}
}
