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
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="css/clean-blog.css" rel="stylesheet">
</head>
<body>
	{{ partial('menu') }}
	{{ partial('header') }}
	{{ flash.output() }}
	{{ content() }}
	<hr>
	{{ partial('footer') }}
	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.bundle.js"></script>
	<script src="/js/clean-blog.js"></script>
</body>
</html>
