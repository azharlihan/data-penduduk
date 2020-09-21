<?php

namespace Controllers;

class Penduduk extends \Controller
{
	public function index()
	{
		$this->view('daftarPenduduk');
	}

	public function form()
	{
		$daftarHbkel = $this->model('penduduk')->getDaftarHbkel();
		$this->view('formPenduduk', [
			'daftarHbkel' => $daftarHbkel,
		]);
	}

	public function getdaftarpenduduk()
	{
		$daftarPenduduk = $this->model('Penduduk')->getDaftarPenduduk($this->postData());

		$this->response($daftarPenduduk);
	}
}
