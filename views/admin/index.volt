{% if cronoff %}
	<a href="/admin/cronoff/0" class="btn btn-danger">Запустить крон</a>
{% else %}
	<a href="/admin/cronoff/1" class="btn btn-success">Остановить крон</a>
{% endif %}
<a href="/admin/clearcache/?clear=1" class="btn btn-success">Очистить кеш</a><br><br>
<form action="/admin/setgroupid/" method="post">
	<input type="text" name="sms_request_id" placeholder="Номер смс рассылки">
	<input type="texT" name="send_group_external" placeholder="Номер группы рассылки">
	<button type="submit" class="btn btn-primary">Задать</button>
</form>
<br><br>
