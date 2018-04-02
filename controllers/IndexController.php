<?php
namespace Controller;
use Model\Logger;
class IndexController extends \Phalcon\Mvc\Controller
{
	public function indexAction(){
		$this->tag->setTitle('Test');
		//$this->flash->error('test');
		//$this->response->setJsonContent(['status' => 'OK']);
	}
}
