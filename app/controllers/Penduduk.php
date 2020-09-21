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
		$result = $this->model('Penduduk')->postDataPenduduk($this->stream);

		$this->response($result);
	}

	public function putdatapenduduk()
	{
		$result = $this->model('Penduduk')->putDataPenduduk($this->stream);

		$this->response($result);
	}
}
