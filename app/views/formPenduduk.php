<?= $this->view('_header'); ?>
<div class="container">
	<div class="row mt-3">
		<div class="col-12 col-md-6 offset-md-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title text-center"><?= $type; ?> Data Penduduk</h5>
					<form action="<?= BASEURL; ?>" id="formPenduduk">
						<input type="hidden" name="type" value="<?= strtolower($type); ?>">
						<input type="hidden" name="old_nik" value="<?= $detailPenduduk['nik']; ?>">
						<div class="form-group">
							<label for="no_kk">Nomor Kartu Keluarga</label>
							<input type="text" class="form-control" name="no_kk" id="no_kk" placeholder="Ketik nomor KK" value="<?= !isset($detailPenduduk['no_kk']) ? null : $detailPenduduk['no_kk']; ?>">
						</div>
						<div class="form-group">
							<label for="nik">Nomor Induk Kependudukan</label>
							<input type="text" class="form-control" name="nik" id="nik" placeholder="Ketik NIK" value="<?= !isset($detailPenduduk['nik']) ? null : $detailPenduduk['nik']; ?>">
						</div>
						<div class="form-group">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Ketik nama lengkap" value="<?= !isset($detailPenduduk['nama_lengkap']) ? null : $detailPenduduk['nama_lengkap']; ?>">
						</div>
						<div class="form-group">
							<label for="id_stat_hbkel">Status Hubungan Keluarga</label>
							<select name="id_stat_hbkel" id="id_stat_hbkel" class="form-control">
								<option value="">Pilih hubungan keluarga</option>
								<?php foreach ($daftarHbkel as $v) : ?>
									<?php if (isset($detailPenduduk['id_stat_hbkel'])) : ?>
										<option value="<?= $v['id_stat_hbkel']; ?>" <?php if ($v['id_stat_hbkel'] == $detailPenduduk['id_stat_hbkel']) echo "selected" ?>>
									<?php else : ?>
										<option value="<?= $v['id_stat_hbkel']; ?>">
									<?php endif; ?>
										<?= $v['stat_hbkel']; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<a href="<?= BASEURL; ?>" class="btn btn-danger">Batal</a>
							<button type="button" id="submit" class="btn btn-primary"><?= $submitText; ?></button>
						</div>
					</form>
				</div>
			</div>

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