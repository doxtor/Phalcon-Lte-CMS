<?php
namespace Library;
class View extends \Phalcon\Mvc\View{
	public function __construct(){
		$di = null;
		$this->setViewsDir(BASE_PATH . '/views/');
		$this->registerEngines(['.volt' => 'volt']);
	}
}
