<?php
namespace Library;

use Phalcon\Logger\Adapter;
use Phalcon\Logger\AdapterInterface;
class Logger extends Adapter implements AdapterInterface
{
	public function logInternal($message, $type, $time, $context = [])
	{
		$logger = new \Model\Logger();
		$logger->assign([
			'type' => $type,
			'message' => $message,
		]);
		$logger->save();
	}
	public function getFormatter(){}
	public function close(){}
	public function begin(){}
	public function commit(){}
	public function rollback(){}
}
