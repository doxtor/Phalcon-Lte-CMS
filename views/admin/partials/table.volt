<table class="table">
	<thead>
	<tr>
		{% for item in list %} {% if item['sql'] is defined %}
		<th>{{ item['name'] }}</th>
		{% endif %} {% endfor %}
	</tr>
	</thead>
	{% if is_sortable %}
	<tbody class="sortable" sort-link="{{ sort_link }}">
	{% for item in pagination.items %}
	<tr id="{{ item['id'] }}">
		{% for key, value in item %}
		<td>
			{% if loop.first %}
			<a href="{{ edit_link }}{{ item[primary_key_name] }}">{{ value }}</a>
			<span class="badge label-default cursor-move">
						{{ item[order_column_name] }}
					</span>
			{% else %}
			{% if list[key]['type'] is defined and list[key]['type'] == 'select'  %}
			{{ list[key]['options'][value] }}
			{% else %}
			{{ value }}
			{% endif %}
			{% endif %}
		</td>
		{% endfor %}
	</tr>
	{% elsefor %}
	<p>Пусто</p>
	{% endfor %}
	</tbody>
	{% else %}
	<tbody>
	{% for items in pagination.items %}
	<tr>
		{% for key, item in items %}
		<td>
			{% if loop.first %}
			<a href="{{ edit_link }}{{ items[primary_key_name] }}">{{ item }}</a>
			{% else %}
			{% if list[key]['type'] is defined and list[key]['type'] == 'select'  %}
			{{ list[key]['options'][item] }}
			{% else %}
			{{ item }}
			{% endif %}
			{% endif %}
		</td>
		{% endfor %}
	</tr>
	{% elsefor %}
	<p>Пусто</p>
	{% endfor %}
	</tbody>
	{% endif %}
	<tfoot>
	<tr>
		{% for item in list %} {% if item['sql'] is defined %}
		<th>{{ item['name'] }}</th>
		{% endif %} {% endfor %}
	</tr>
	</tfoot>
</table>