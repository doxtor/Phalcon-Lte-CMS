<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/">Главная</a>
	</div>
<div id="navbar" class="navbar-collapse collapse">
	<ul class="nav navbar-nav">
		<li><a class="navbar-brand">{{ get_title('') }}</a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<li{% if router.getControllerName() == 'request' %} class="active"{% endif %}>
			<a href="/" title="Список рассылок"><i class="fa fa-fw fa-list"></i></a>
		</li>
		<li{% if router.getControllerName() == 'black' %} class="active"{% endif %}>
			<a href="/black" title="Черный список"><i class="fa fa-fw fa-book"></i></a>
		</li>
		<li{% if router.getControllerName() == 'log' %} class="active"{% endif %}>
			<a href="/log" title="Лог"><i class="fa fa-fw fa-history"></i></a>
		</li>
		<li{% if router.getControllerName() == 'details' %} class="active"{% endif %}>
			<a href="/details" title="Детальный отчет"><i class="fa fa-fw fa-phone-square"></i></a>
		</li>
		{% if session.get('role') == 'Admin' %}
		<li{% if router.getControllerName() == 'charts' %} class="active"{% endif %}>
			<a href="/charts" title="Графики"><i class="fa fa-fw fa-line-chart"></i></a>
		</li>
		<li{% if router.getControllerName() == 'admin' %} class="active"{% endif %}>
			<a href="/admin" title="Очистить кеш"><i class="fa fa-fw fa-eraser"></i></a>
		</li>
		{% endif %}
		<li>
			<a href="#" onclick="resetFilter();return false;" title="Сбросить фильтр"><i class="fa fa-fw fa-times"></i></a>
		</li>
		<li><a href="/user/logout">Выход ({{ session.get('name') }}) <i class="fa fa-fw fa-sign-out"></i></a></li>
	</ul>
</div>
</nav>
