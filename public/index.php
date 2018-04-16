<?php
define('BASE_PATH', realpath('..'));
define('LIBRARY_PATH', BASE_PATH . '/Library/');
define('MODULES_PATH', BASE_PATH . '/Modules/');
define('ADMIN_FOLDER', 'admin');

(new \Phalcon\Loader())
	->registerNamespaces([
		'Library' => LIBRARY_PATH,
		'Modules' => MODULES_PATH
	], true)->register();
try {
	if (preg_match('/^\/'.ADMIN_FOLDER.'(\/|$)/', $_GET['_url'])){
		$app = new \Library\Admin();
	}else{
		$app = new \Library\Bootstrap();
	}
	echo $app->run();
} catch (\Exception $e) {
	echo $e->getMessage();
}
