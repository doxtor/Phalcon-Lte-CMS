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
	{{ assets.outputCss("header_css") }}
	{{ assets.outputCss() }}
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
	<footer class="footer">
		<div class="container">
			<p class="pull-left">© БК "Бинго-Бум", 2017.</p>
		</div>
	</footer>
	{{ assets.outputJs("footer_js") }}
	{{ assets.outputJs() }}
</body>
</html>
