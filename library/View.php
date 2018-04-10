<?php
namespace Library;
class View extends \Phalcon\Mvc\View{
	public function __construct(){
		$this->setMainView(VIEWS_PATH . '/index');
		$this->setLayoutsDir(VIEWS_PATH . '/layouts/');
		$this->setPartialsDir(VIEWS_PATH . '/partials/');
		$this->registerEngines(['.volt' => 'volt']);
		//$this->setLayout('main');
	}
}
