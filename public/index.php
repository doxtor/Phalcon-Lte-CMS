<?php
define('BASE_PATH', realpath('..'));
define('LIBRARY_PATH', BASE_PATH . '/library/');

(new \Phalcon\Loader())
	->registerNamespaces(['Library' => LIBRARY_PATH], true)
	->register();
try {
	$app = new \Library\Bootstrap();
	echo $app->run();
} catch (\Exception $e) {
	echo $e->getMessage();
}
