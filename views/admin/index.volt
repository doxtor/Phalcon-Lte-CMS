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
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	{{ dump(this.modules) }}
	{{ content() }}
</body>
</html>
