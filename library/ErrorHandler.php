<?php
namespace Library;

class ErrorHandler extends \Phalcon\Mvc\User\Component
{
	public function __construct()
	{
		$config   = $this->di->getShared('config');
		$logger   = $this->di->getShared('logger');

		ini_set('display_errors', $config->get('debug')->get('error_reporting'));
		error_reporting(E_ALL);

		set_error_handler(
			function ($errorNumber, $errorString, $errorFile, $errorLine) use ($logger) {
				if (0 === $errorNumber & 0 === error_reporting()) {
					return;
				}
				$logger->error(
					sprintf("[%s] [%s] %s - %s",
					$errorNumber, $errorLine, $errorString, $errorFile)
				);
			}
		);

		set_exception_handler(
			function () use ($logger) {
				$logger->error(json_encode(debug_backtrace()));
			}
		);
	}
}
