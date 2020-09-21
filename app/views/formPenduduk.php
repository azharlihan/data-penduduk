<?= $this->view('_header'); ?>

<div class="container">
	<div class="row">
		<div class="col-12 col-sm-6">
			<h3>Penduduk</h3>
		</div>
		<div class="col-12 col-sm-6 text-right">
			<a href="<?= BASEURL; ?>">Kembali</a>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-6 offset-md-3">
			<form action="<?= BASEURL; ?>" id="formPenduduk">
				<input type="hidden" name="">
				<div class="form-group">
					<label for="no_kk">Nomor Kartu Keluarga</label>
					<input type="text" class="form-control" name="no_kk" id="no_kk" placeholder="Ketik nomor KK">
					<small id="emailHelp" class="form-text text-muted d-none">We'll never share your email with anyone else.</small>
				</div>
				<div class="form-group">
					<label for="nik">Nomor Induk Kependudukan</label>
					<input type="text" class="form-control" name="nik" id="nik" placeholder="Ketik NIK">
				</div>
				<div class="form-group">
					<label for="nama_lengkap">Nama Lengkap</label>
					<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Ketik nama lengkap">
				</div>
				<div class="form-group">
					<label for="id_stat_hbkel">Status Hubungan Keluarga</label>
					<select name="id_stat_hbkel" id="id_stat_hbkel" class="form-control">
						<option value="">Pilih hubungan keluarga</option>
						<?php foreach ($daftarHbkel as $v) : ?>
							<option value="<?= $v['id_stat_hbkel']; ?>">
								<?= $v['stat_hbkel']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->view('_script'); ?>
<?= $this->view('_footer'); ?>