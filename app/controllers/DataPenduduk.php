<?php

namespace Controllers;

class DataPenduduk extends \BaseController
{
	public function index()
	{
		$daftarPenduduk = $this->model('PendudukModel')->getDaftarPenduduk();

		$this->view('daftarPenduduk', [
			'daftarPenduduk' => $daftarPenduduk
		]);
	}
}
