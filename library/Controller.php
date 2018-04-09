<?php
namespace Library;
class Controller extends \Phalcon\Mvc\Controller{
	public function setTitle($title = null){
		$this->tag->setTitle($title);
	}
	public function getTitle(){
		return $this->tag->getTitle('');
	}
}
