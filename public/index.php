<?php
define('BASE_PATH', realpath('..'));
try {
	require_once BASE_PATH . '/Bootstrap.php';
	echo (new \Bootstrap())->run();
} catch (\Exception $e) {
	echo $e->getMessage();
}
