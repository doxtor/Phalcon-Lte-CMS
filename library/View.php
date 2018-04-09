<?php
namespace Library;
class View extends \Phalcon\Mvc\View{
	public function __construct(){
		$this->setMainView(BASE_PATH . '/views/index');
		$this->setLayoutsDir(BASE_PATH . '/views/layouts/');
		$this->setPartialsDir(BASE_PATH . '/views/partials/');
		$this->registerEngines(['.volt' => 'volt']);
		//$this->setLayout('main');
	}
}
