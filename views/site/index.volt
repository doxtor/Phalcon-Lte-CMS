{{ get_doctype() }}
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="{{ config.view.author }}">
	<meta name="keywords" content="{{ get_keywords() }}">
	<meta name="description" content="{{ get_description() }}">
	<link href="favicon.ico" rel="shortcut icon" type="image/png"/>
	{{ get_title() }}
	{{ assets.outputCss('header_site') }}
	<link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
	{{ partial('menu') }}
	{{ partial('header') }}
	<div class="container"><div class="row">
		<div class="col-lg-8 col-md-10 mx-auto">
			{{ flash.output() }}
			{{ content() }}
		</div>
	</div></div>
	<hr>
	{{ partial('footer') }}
	{{ assets.outputJs('footer_site') }}
</body>
</html>
