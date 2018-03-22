<?php
define('APP_PATH', dirname(__FILE__));
include APP_PATH . '/Bootstrap.php';
use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;
class Cli extends Bootstrap{
	/**
	 * @param $argv
	 * @throws Exception
	 */
	public function _run($argv)
	{
		$this->di = new CliDI();
		$this->initLoader();
		$this->initConfig();
		$this->registerDirs();
		$this->registerNamespaces();
		$this->initCache();
		$this->initDB();
		$this->initLogger();
		$this->initErrorHandler();
		$console = new ConsoleApp();
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

	/**
	* Регистрация дириктории tasks.
	*/
	protected function registerDirs()
	{
		$loader = new Loader();
		$loader->registerDirs([APP_PATH . '/tasks/']);
		$loader->register();
	}
}
(new Cli())->_run($argv);