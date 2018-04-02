<?php
namespace Library;
use Phalcon\Http\Request;
class Router extends \Phalcon\Mvc\Router{
	function __construct()
	{
		$this->setDefaultController('index');
		$this->add('/:controller/:action',         ['controller' => 1,'action' => 2]);
		$this->add('/:controller/:action/:params', ['controller' => 1,'action' => 2, 'params' => 3]);
	}
}
