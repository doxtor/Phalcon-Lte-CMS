{{ get_doctype() }}
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	{{ get_title() }}
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/fontawesome-all.min.css" rel="stylesheet" type="text/css">
	<link href="/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
</head>
<body>
	{{ partial('menu') }}
	{{ flash.output() }}
	{{ content() }}
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/jquery.dataTables.min.js"></script>
	<script src="/js/list.js"></script>
</body>
</html>
