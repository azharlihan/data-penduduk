<script src="<?= BASEURL; ?>/assets/jquery-3.3.1.min.js"></script>
<script src="<?= BASEURL; ?>/assets/bootstrap/bootstrap.min.js"></script>
<script src="<?= BASEURL; ?>/assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?= BASEURL; ?>/assets/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= BASEURL; ?>/assets/datatables/dataTables.responsive.min.js"></script>
<script src="<?= BASEURL; ?>/assets/datatables/responsive.bootstrap4.min.js"></script>
<script>
	var url = '<?= BASEURL; ?>';

	function getFormData(formSelector) {
		var unindexedArray = $(formSelector).serializeArray();
		var indexedArray = {};

		unindexedArray.map((v) => {
			indexedArray[v.name] = v.value;
		});

		return indexedArray;
	}

	function myFetch(path, data = {}) {
		return fetch(url + path, {
			method: 'POST',
			body: JSON.stringify(data)
		}).then(res => {
			return Promise.resolve(res);
		}).then(raw => {
			return raw.json()
		}).catch(e => {
			alert(e);
		});
	}
</script>