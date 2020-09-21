<?= $this->view('_header'); ?>
<div class="container">
	<div class="row">
		<div class="col-12 col-sm-6">
			<h3><?= $type; ?> Data Penduduk</h3>
		</div>
		<div class="col-12 col-sm-6 text-right">
			<a href="<?= BASEURL; ?>">Kembali</a>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-6 offset-md-3">
			<form action="<?= BASEURL; ?>" id="formPenduduk">
				<input type="hidden" name="type" value="<?= strtolower($type); ?>">
				<input type="hidden" name="old_nik" value="<?= $detailPenduduk['nik']; ?>">
				<div class="form-group">
					<label for="no_kk">Nomor Kartu Keluarga</label>
					<input type="text" class="form-control" name="no_kk" id="no_kk" placeholder="Ketik nomor KK" value="<?= $detailPenduduk['no_kk']; ?>">
				</div>
				<div class="form-group">
					<label for="nik">Nomor Induk Kependudukan</label>
					<input type="text" class="form-control" name="nik" id="nik" placeholder="Ketik NIK" value="<?= $detailPenduduk['nik']; ?>">
				</div>
				<div class="form-group">
					<label for="nama_lengkap">Nama Lengkap</label>
					<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Ketik nama lengkap" value="<?= $detailPenduduk['nama_lengkap']; ?>">
				</div>
				<div class="form-group">
					<label for="id_stat_hbkel">Status Hubungan Keluarga</label>
					<select name="id_stat_hbkel" id="id_stat_hbkel" class="form-control">
						<option value="">Pilih hubungan keluarga</option>
						<?php foreach ($daftarHbkel as $v) : ?>
							<option value="<?= $v['id_stat_hbkel']; ?>" <?php if ($v['id_stat_hbkel'] == $detailPenduduk['id_stat_hbkel']) echo "selected" ?>>
								<?= $v['stat_hbkel']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<button type="button" id="submit" class="btn btn-primary"><?= $submitText; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->view('_script'); ?>

<script>
	$(document).ready(() => {
		$('#submit').on('click', () => {
			var formPenduduk = getFormData('#formPenduduk');
			var path = formPenduduk.type == 'tambah' ? '/penduduk/postdatapenduduk' : '/penduduk/putdatapenduduk';
			myFetch(path, formPenduduk).then((result) => {
				alert(result.message);
				if (result.status == 'ok') {
					window.location = url;
				}
			})
		})
	})
</script>

<?= $this->view('_footer'); ?>