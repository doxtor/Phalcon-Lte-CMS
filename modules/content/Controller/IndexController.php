<?php
namespace Content\Controller;
use Library\Model\Logger;
class IndexController extends \Library\Controller
{
	public function indexAction(){
		//print_r(\Content\Model\Content::find()->toArray());
		$this->tag->setTitle('Test 123');
	}
}
