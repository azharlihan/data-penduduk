<?php

namespace Controllers;

class DataPenduduk extends \Controller
{
	public function index()
	{
		$daftarPenduduk = $this->model('PendudukModel')->getDaftarPenduduk();

		$this->view('daftarPenduduk', [
			'daftarPenduduk' => $daftarPenduduk
		]);
	}
}
