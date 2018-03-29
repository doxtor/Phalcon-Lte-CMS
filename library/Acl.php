<?php
namespace Library;
use Phalcon\Mvc\User\Component;
class Acl extends Component{
	private $access = null;
	public function haveAccess($action = null,$controller = null){
		if(isset($this->access[$controller][$action])){
			return $this->access[$controller][$action];
		}
		$router = $this->di->get('router');
		$controller = $controller ?? $router->getControllerName();
		$action = $action ?? $router->getActionName() ?: 'index';
		$role = $this->session->get('role') ?: 'Guest';

		if($role === 'Administrator'){
			$this->access[$controller][$action] = true;
			return true;
		}
		if($controller === 'user'){
			$this->access[$controller][$action] = true;
			return true;
		}
		$key = 'access_'.$role.'_'.$controller.'_'.$action;
		$access = $this->cache->get($key);
		if($access !== "da" && $access !== "net"){
			$result = \Model\Acl::findFirst([
					'conditions' => 'controller  = ?2 AND action = ?3',
					'bind'       => [
						2 => $controller,
						3 => $action,
					]
				]);
			$access = $result ? true : false;
			$this->cache->save($key,$access);
		}
		$this->access[$controller][$action] = $access;
		return $this->access[$controller][$action];
	}
}
