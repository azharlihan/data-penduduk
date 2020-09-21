<?php

namespace Controllers;

class DataPenduduk extends \Controller
{
	public function index()
	{
		$this->view('daftarPenduduk');
	}

	public function getdaftarpenduduk()
	{
		$daftarPenduduk = $this->model('Penduduk')->getDaftarPenduduk($this->postData());

		$this->response($daftarPenduduk);
	}
}
