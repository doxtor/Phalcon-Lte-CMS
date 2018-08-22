<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
	<a class="navbar-brand" href="/admin/">Admin Panel</a>
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
	<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
	<li class="nav-item{% if router.getRewriteUri() == '/site/site/list' %} active{% endif %}" data-toggle="tooltip" data-placement="right" title="Site pages">
		<a class="nav-link" href="/admin/site/site/list"><i class="fa fa-file"></i><span class="nav-link-text">
Site pages</span></a>
	</li>
	<li class="nav-item{% if router.getRewriteUri() == '/users/users/list' %} active{% endif %}" data-toggle="tooltip" data-placement="right" title="Users">
		<a class="nav-link" href="/admin/users/users/list"><i class="fa fa-users"></i><span class="nav-link-text"> Users</span></a>
	</li>
	<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
		<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
		<i class="fa fa-fw fa-sitemap"></i><span class="nav-link-text"> Menu Levels</span>
		</a>
		<ul class="sidenav-second-level collapse" id="collapseMulti">
			<li><a href="#">Second Level Item</a></li>
			<li><a href="#">Second Level Item</a></li>
			<li><a href="#">Second Level Item</a></li>
			<li>
				<a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Third Level</a>
				<ul class="sidenav-third-level collapse" id="collapseMulti2">
					<li><a href="#">Third Level Item</a></li>
					<li><a href="#">Third Level Item</a></li>
					<li><a href="#">Third Level Item</a></li>
				</ul>
			</li>
		</ul>
		</li>
	</ul>
	<ul class="navbar-nav sidenav-toggler"><li class="nav-item"><a class="nav-link text-center" id="sidenavToggler"><i class="fa fa-fw fa-angle-left"></i></a></li></ul>
	<ul class="navbar-nav ml-auto"><li class="nav-item"><a href="/admin/users/users/logout" class="nav-link"><i class="fa fa-sign-out-alt"></i>Logout</a></li></ul>
</div>
</nav>
