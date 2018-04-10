$(document).ready(function() {
	var url = '';
	$('.search').each(function() {
		var value = localStorage.getItem($(this).attr('name'));
		if(value && value != 'null' && value != ''){
			$(this).val(value);
			url += '&'+ $(this).attr('name') + '=' + value;
		}
	});
	MainTable = $('#MainTable').DataTable({
		responsive: true,
		dom : "<'row'<'col-md-3'f><'col-md-6'p><'col-md-3'l>>rt<'row'<'col-md-6'><'col-md-6'i>>",
		columnDefs : [{ "targets": [-1], "orderable": false }],
		order : [[ 0, "desc" ]],
		language : {
			"processing": "Подождите...",
			"search": "Поиск:",
			"lengthMenu": "Показать _MENU_ записей",
			"info": "Записи с _START_ до _END_ из _TOTAL_ записей",
			"infoEmpty": "Записи с 0 до 0 из 0 записей",
			"infoFiltered": "(отфильтровано из _MAX_ записей)",
			"infoPostFix": "",
			"loadingRecords": "Загрузка записей...",
			"zeroRecords": "Записи отсутствуют.",
			"emptyTable": "В таблице отсутствуют данные",
			"paginate": {
				"first": "Первая",
				"previous": "Предыдущая",
				"next": "Следующая",
				"last": "Последняя"
			},
			"aria": {
				"sortAscending": ": активировать для сортировки столбца по возрастанию",
				"sortDescending": ": активировать для сортировки столбца по убыванию"
			}
		},
		processing : true,
		serverSide : true,
		ajax : {'url': url, 'type': 'POST'},
		stateSave : true,
		createdRow: function (row, data, index) {$(row).addClass(data.class);}
	});
});
