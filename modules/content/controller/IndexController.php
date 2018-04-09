<?php
namespace Content\Controller;
use Library\Model\Logger;
class IndexController extends \Library\Controller
{
	public function indexAction(){
		$this->tag->setTitle('Test');
	}
}
