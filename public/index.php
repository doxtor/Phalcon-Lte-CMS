<?php
define('APP_PATH', realpath('..'));
try {
	require_once APP_PATH . '/Bootstrap.php';
	echo (new \Bootstrap())->run();
} catch (\Exception $e) {
	echo $e->getMessage();
}
