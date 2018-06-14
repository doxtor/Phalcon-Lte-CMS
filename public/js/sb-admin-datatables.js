// Call the dataTables jQuery plugin
$(document).ready(function() {
	var ajaxurl = '?_ajax=1';
	$('.search').each(function() {
		var value = localStorage.getItem($(this).attr('name'));
		if(value && value != 'null' && value != ''){
			$(this).val(value);
			ajaxurl += '&'+ $(this).attr('name') + '=' + value;
		}
	});
	$('#dataTable').DataTable({
		responsive: true,
		//order: [[ 0, 'desc']],
		processing: true,
		serverSide: true,
		ajax: {
			url: ajaxurl,
			type: 'POST',
		},
		stateSave: true,
		createdRow: function (row, data, index) {
			$(row).addClass(data.class);
		}
	});
});
