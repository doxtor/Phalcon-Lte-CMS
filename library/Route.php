<?php
/**
* Router config file for set routing logics
*
*/
use Phalcon\Mvc\Router;
$router = new Router();
$router->setDefaultController('halls');
$router->add('/:controller/:action',			['controller' => 1,'action' => 2]);
$router->add('/:controller/:action/:params',	['controller' => 1,'action' => 2, 'params' => 3]);
return $router;
