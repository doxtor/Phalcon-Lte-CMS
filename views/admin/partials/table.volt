<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
	<thead><tr>
		{% for item in columns %}
			<th>{{ item['name'] }}</th>
		{% endfor %}
	</tr></thead>
</table>
