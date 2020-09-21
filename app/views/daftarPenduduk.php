<?= $this->view('_header'); ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-sm-6">
			<h3>Daftar Penduduk</h3>
		</div>
		<div class="col-12 col-sm-6 text-right">
			<a href="<?= BASEURL; ?>/penduduk/form/tambah">Tambah Baru</a>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<table id="tablePenduduk" class="table table-bordered table-hover" style="width: 100%;"></table>
		</div>
	</div>
</div>

<?= $this->view('_script'); ?>

<script>
	$(document).ready(() => {
		var tablePenduduk = $('#tablePenduduk').DataTable({
			ajax: {
				url: url + '/penduduk/getdaftarpenduduk'
			},
			language: {
				searchPlaceholder: 'Ketik KK / NIK / Nama',
				processing: '<strong>Memuat Data . . .</strong>',
			},
			order: [
				[6, 'desc']
			],
			processing: true,
			responsive: true,
			searchDelay: 1000,
			serverSide: true,
			serverMethod: 'POST',
			columns: [{
					data: 'no_kk',
					title: 'No KK'
				},
				{
					data: 'nik',
					title: 'NIK'
				},
				{
					data: 'nama_lengkap',
					title: 'Nama'
				},
				{
					data: 'gender',
					title: 'Jenis Kelamin',
					orderable: false
				},
				{
					data: 'birth_date',
					title: 'Tgl Lahir',
					orderable: false,
					render: (data, type, row) => {
						return `${row.birth_date} (${row.age.padStart(2,'0')}&nbsp;Tahun)`;
					}
				},
				{
					data: 'stat_hbkel',
					title: 'Hubungan Keluarga',
					render: (data, type, row) => {
						return row.id_stat_hbkel == 1 ? `<strong>${row.stat_hbkel}</strong>` : row.stat_hbkel;
					}
				},
				{
					data: 'tanggal_update',
					title: 'Tgl Update',
				}
			]
		});
	})
</script>

<?= $this->view('_footer'); ?>