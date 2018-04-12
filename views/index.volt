{{ get_doctype() }}
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	{{ get_title() }}
	{{ assets.outputCss('header_css') }}
	{{ assets.outputCss() }}
</head>
<body>
	{{ partial('menu') }}
	{{ flash.output() }}
	{{ content() }}
	{{ assets.outputJs('footer_js') }}
	{% do assets.addJs('js/list.js') %}
	{{ assets.outputJs() }}
</body>
</html>
