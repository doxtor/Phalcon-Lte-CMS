<?php
define('BASE_PATH', realpath('..'));
define('LIBRARY_PATH', BASE_PATH . '/Library/');
define('MODULES_PATH', BASE_PATH . '/Modules/');
define('CACHE_PATH', BASE_PATH . '/cache/');
define('ASSETS_PATH', BASE_PATH . '/public/assets/');
define('ASSETS_URL', 'assets/');

$config = include BASE_PATH . '/config.php';
(new \Phalcon\Loader())
	->registerNamespaces([
		'Library' => LIBRARY_PATH,
		'Modules' => MODULES_PATH
	], true)->register();
try {
	$find = '/^\/' . $config->get('admin')->get('url') . '(\/|$)/';
	if (isset($_GET['_url']) && preg_match($find, $_GET['_url'])){
		$_GET['_url'] =  '/'. preg_replace($find, '', $_GET['_url']);
		define('CLIENT', 'admin');
		define('VIEWS_PATH', BASE_PATH . '/views/'.CLIENT);
		$app = new \Library\Admin();
	}elseif(php_sapi_name() === 'cli'){
        define('CLIENT', 'cli');
		(new \Library\Cli())->_run($argv);
		exit;
	}else{
		define('CLIENT', 'site');
		define('VIEWS_PATH', BASE_PATH . '/views/'.CLIENT);
		$app = new \Library\Site();
	}
	echo $app->run();
} catch (\Exception $e) {
	echo $e->getMessage();
}
