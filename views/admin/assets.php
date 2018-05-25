<?php
return [
	'header_admin' => [
		'path' => BASE_PATH . '/public/assets/header.admin.css',
		'uri' => 'assets/header.admin.css',
		'type' => 'css',
		'files' => [
			BASE_PATH . '/public/css/admin.css',
			BASE_PATH . '/public/css/bootstrap.css',
			BASE_PATH . '/public/css/fa-svg-with-js.css',
		],
	],
	'footer_admin' => [
		'path' => BASE_PATH . '/public/assets/footer.admin.js',
		'uri' => 'assets/footer.admin.js',
		'type' => 'js',
		'files' => [
			BASE_PATH . '/public/js/jquery.min.js',
			BASE_PATH . '/public/js/bootstrap.js',
			BASE_PATH . '/public/js/fontawesome-all.js',
		],
	],
];
