<?php
namespace Library;
class Cli extends \Library\Bootstrap{
	public function _run($argv){
		$this->di = new \Phalcon\Di\FactoryDefault\Cli();
		$this->initLoader();
		$this->initConfig();
		$this->initCache();
		$this->initDB();
		$console = new \Phalcon\Cli\Console();
		$console->setDI($this->di);
		$arguments = [];

		foreach ($argv as $k => $arg) {
			if ($k === 1) {
				$arguments['task'] = $arg;
			} elseif ($k === 2) {
				$arguments['action'] = $arg;
			} elseif ($k >= 3) {
				$arguments['params'][] = $arg;
			}
		}
		try {
			$console->handle($arguments);
		} catch (\Phalcon\Exception $e) {
			echo $e->getMessage();
		}
	}
}
