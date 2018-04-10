<?php
define('BASE_PATH', dirname(__FILE__));
(new \Phalcon\Loader())
	->registerNamespaces(['Library' => BASE_PATH . '/library/'], true)
	->register();

class Cli extends \Library\Bootstrap
{
	public function _run($argv)
	{
		$this->di = new \Phalcon\Di\FactoryDefault\Cli();
		$this->initLoader();
		$this->initConfig();
		$this->registerDirs();
		$this->registerNamespaces();
		$this->initCache();
		$this->initDB();
		$this->initLogger();
		$this->initErrorHandler();
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
	protected function registerDirs()
	{
		$loader = new \Phalcon\Loader();
		$loader->registerDirs([BASE_PATH . '/tasks/']);
		$loader->register();
	}
}
(new Cli())->_run($argv);
