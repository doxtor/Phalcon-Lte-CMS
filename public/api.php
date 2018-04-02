<?php
define('BASE_PATH', realpath('..'));
try {
	require_once BASE_PATH . '/Api.php';
	echo (new \Api())->run();
} catch (\Exception $e) {
	echo $e->getMessage();
}
