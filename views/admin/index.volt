{{ get_doctype() }}
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Daniiar Nurmanbetov">
	<link href="/favicon.ico" rel="shortcut icon" type="image/png"/>
	{{ get_title() }}
	{{ assets.outputCss('header_admin') }}
	{{ assets.outputCss() }}
</head>
<body>
	<div class="container-fluid h-100">
		<div class="row h-100">
			{{ partial('menu') }}
			<main class="col bg-faded py-3">
				{{ flash.output() }}
				{{ content() }}
			</main>
		</div>
	</div>
	{{ assets.outputJs('footer_admin') }}
	{% do assets.addJs('js/list.js') %}
	{{ assets.outputJs() }}
</body>
</html>
