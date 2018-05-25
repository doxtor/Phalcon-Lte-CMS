<?php
namespace Modules\Users;

use Modules\Users\Model\Users;
class UsersAdmin extends \Library\AdminController{
	public function indexAction(){

	}
	public function loginAction(){
		if($this->session->get('role') === 'admin'){
			$this->redirect();
		}elseif(!$this->request->isPost()){
			$this->view->setLayout('blank');
		}else{
			$login = $this->request->getPost('login');
			$password = $this->request->getPost('password');
			$user = Users::findFirst([
				'columns' => 'id, password, role',
				'conditions' => 'login = :login: OR email = :login:',
				'bind' => ['login' => $login]
			]);
			if($user && $user->password == md5($password . ':' . $password)){
				$this->session->set('role', $user->role);
				$this->session->set('id', $user->id);
			}
		}
	}

}
