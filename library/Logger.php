<?php
namespace Library;

use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Adapter\File;
class Logger extends File
{
	/**
	* Cache constructor.
	* @param $config
	*/
	public function __construct($config)
	{
		$fileName = $config->get('defaultFilename', 'application');
		$format = $config->get('format', '[%date%][%type%] %message%');
		$logFile   = sprintf(
				'%s/logs/%s-%s.log',
				APP_PATH,
				date('Ymd'),
				$fileName
		);
		$logger    = new File($logFile);
		$logger->setFormatter(new Line($format));
		return $logger;
	}
}
