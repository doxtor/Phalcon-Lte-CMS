<?php
define('BASE_PATH', realpath('..'));
(new \Phalcon\Loader())
	->registerNamespaces(['Library' => BASE_PATH . '/library/'], true)
	->register();
try {
	$app = new \Library\Bootstrap();
	echo $app->run();
} catch (\Exception $e) {
	echo $e->getMessage();
}
