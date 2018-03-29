<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut Icon" href="/favicon.ico" type="image/x-icon"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	{{ get_title() }}
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
</head>
<body>
	<div id="wrapper">
		{{ partial('partials/menu') }}
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						{{ flash.output() }}
						{{ content() }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
</body>
</html>
