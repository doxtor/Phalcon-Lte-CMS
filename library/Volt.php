<?php
namespace Library;
class Volt extends \Phalcon\Mvc\View\Engine\Volt{
	public function __construct($view, $di){
		parent::__construct($view, $di);
		$this->setOptions([
			'compiledPath'      => BASE_PATH . '/cache/',
			'compiledSeparator' => '_',
			'compiledExtension' => '.php',
		]);

	}
}
