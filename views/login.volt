<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="index,follow">
	{{ get_title() }}
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
	{{ stylesheet_link('css/bootstrap.min.css') }}
</head>
<body>
	<div class="wrapper">
		{{ flash.output() }}
		{{ content() }}
	</div>
	<footer class="footer">
		<div class="container">
			<p class="pull-left">© БК "Бинго-Бум", 2017.</p>
			<p class="pull-right"></p>
		</div>
	</footer>
	{{ javascript_include('js/jquery.min.js') }}
	{{ javascript_include('js/bootstrap.min.js') }}
</body>
</html>
