<?php
namespace Library;
class Logger extends \Phalcon\Logger\Adapter implements \Phalcon\Logger\AdapterInterface
{
	public function logInternal($message, $type, $time, $context = []){
		/*$logger = new LoggerModel();
		$logger->assign([
			'type' => $type,
			'message' => $message,
		]);
		$logger->save();*/
	}
	public function getFormatter(){}
	public function close()       {}
	public function begin()       {}
	public function commit()      {}
	public function rollback()    {}
}
