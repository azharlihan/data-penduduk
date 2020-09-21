<?= $this->view('_header'); ?>

<div class="container-fluid">
	<div class="row mt-3">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-12 col-sm-6">
							<h5 class="card-title">Daftar Penduduk</h5>
						</div>
						<div class="col-12 col-sm-6 text-right">
							<a href="<?= BASEURL; ?>/penduduk/form/tambah" class="btn btn-primary btn-md">Tambah Baru</a>
						</div>
					</div>
					<div class="table-responsive">
						<table id="tablePenduduk" class="table table-bordered table-hover" style="width: 100%;"></table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->view('_script'); ?>

<script>
	var tablePenduduk;

	function deletePenduduk(nik) {
		if (confirm('Hapus data ini?')) {
			myFetch(`/penduduk/delete/${nik}`).then((result) => {
				alert(result.message);
				tablePenduduk.ajax.reload(null, false);
			})
		}
	}
	$(document).ready(() => {
		tablePenduduk = $('#tablePenduduk').DataTable({
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
					title: 'NIK',
					responsivePriority: 2,
				},
				{
					data: 'nama_lengkap',
					title: 'Nama',
					responsivePriority: 1,
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
						return row.id_stat_hbkel == 1 ? `<span class="text-success">${row.stat_hbkel}</span>` : row.stat_hbkel;
					}
				},
				{
					data: 'tanggal_update',
					title: 'Tgl Update',
				},
				{
					data: 'tanggal_create',
					title: 'Tgl Dibuat',
				}
			],
			columnDefs: [{
				title: 'Tools',
				targets: 8,
				data: 'nik',
				render: (d) => {
					let r = `<a class="btn btn-sm btn-primary" href="${url}/penduduk/form/perbarui/${d}">✎</a>`
					r += `<button class="btn btn-sm btn-warning" onclick="deletePenduduk(${d})">🗑</button>`
					return r;
				}
			}]
		});
	})
</script>

<?= $this->view('_footer'); ?>