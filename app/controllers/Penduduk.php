<?php

namespace Controllers;

class Penduduk extends \Controller
{
	public function index()
	{
		$this->view('daftarPenduduk');
	}

	public function form($type = null)
	{
		$daftarHbkel = $this->model('penduduk')->getDaftarHbkel();

		if ($type == 'tambah') {
			$submitText = 'Simpan';
		} else if ($type == 'perbarui') {
			$submitText = 'Perbarui';
		} else {
			$this->redirect(BASEURL . '/penduduk/form/tambah');
		}
		$this->view('formPenduduk', [
			'daftarHbkel' => $daftarHbkel,
			'type' => ucfirst($type),
			'submitText' =>  $submitText
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
}
