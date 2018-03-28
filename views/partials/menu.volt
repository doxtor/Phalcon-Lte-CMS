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
		<li><a href="/user/logout">Выход ({{ session.get('name') }}) <i class="fa fa-fw fa-sign-out"></i></a></li>
	</ul>
</div>
</nav>
