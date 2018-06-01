<?php
return [
	'header_admin' => [
		'path' => BASE_PATH . '/public/assets/header.admin.css',
		'uri' => 'assets/header.admin.css',
		'type' => 'css',
		'files' => [
			BASE_PATH . '/public/css/bootstrap.min.css',
			BASE_PATH . '/public/css/fa-svg-with-js.css',
			BASE_PATH . '/public/datatables/dataTables.bootstrap4.css',
			BASE_PATH . '/public/css/sb-admin.css',
		],
	],
	'footer_admin' => [
		'path' => BASE_PATH . '/public/assets/footer.admin.js',
		'uri' => 'assets/footer.admin.js',
		'type' => 'js',
		'files' => [
			BASE_PATH . '/public/js/jquery.min.js',
			BASE_PATH . '/public/js/bootstrap.bundle.min.js',
			BASE_PATH . '/public/js/jquery.easing.min.js',
			BASE_PATH . '/public/js/fontawesome-all.js',
			BASE_PATH . '/public/datatables/jquery.dataTables.js',
			BASE_PATH . '/public/datatables/dataTables.bootstrap4.js',
			BASE_PATH . '/public/js/sb-admin.js',
			BASE_PATH . '/public/js/sb-admin-datatables.js',

		],
	],
];
