<?php
namespace Library;
use Phalcon\Http\Request;
class Router extends \Phalcon\Mvc\Router{
	function __construct()
	{
		$this->setDefaultModule('content');
		$this->setDefaultController('index');
		$this->setDefaultAction('index');
		$this->add('/:module',                             ['module' => 1, 'controller' => 'index','action' => 'index'])->setName('default');
		$this->add('/:module/:controller',                 ['module' => 1, 'controller' => 2,      'action' => 'index'])->setName('default');
		$this->add('/:module/:controller/:action',         ['module' => 1, 'controller' => 2,      'action' => 3])->setName('default');
		$this->add('/:module/:controller/:action/:params', ['module' => 1, 'controller' => 2,      'action' => 3, 'params' => 4])->setName('default');
	}
}
