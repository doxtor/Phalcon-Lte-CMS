{{ get_doctype() }}
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	{{ get_title() }}
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="/css/clean-blog.min.css" rel="stylesheet">
</head>
<body>
	{{ partial('menu') }}
	{{ partial('header') }}
	{{ flash.output() }}
	{{ content() }}
	<hr>
	{{ partial('footer') }}
	<script src="/js/jquery.min.js"></script>
	<script src="/js/clean-blog.min.js"></script>
</body>
</html>
