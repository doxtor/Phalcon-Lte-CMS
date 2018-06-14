<?php
namespace Modules\Users;

use Modules\Users\Model\Users;
use Phalcon\Tag;
class UsersAdmin extends \Library\AdminController{
	public $title = 'Users';
	public $table = 'Modules\Users\Model\Users';
	public $variables = [
		'' => [
			'phone' => [
				'name' => 'Номер телефона',
				'type' => 'text',
			],
			'status' => [
				'name' => 'Статус',
				'type' => 'select',
				'options' => []
			]
		]
	];

	public $columns = [
		'id' => [
			'name' => 'ID',
			'sql' => true,
		],
		'login' => [
			'name' => 'Login',
			'sql' => true,
		],
		'email' => [
			'name' => 'Email',
			'sql' => true,
		],
		'actions' => [
			'sortable' => true,
			'orderColumnName' => 'sort',
		],
	];

	public function loginAction(){
		if($this->session->get('role') === 'admin'){
			$this->redirect();
		}elseif(!$this->request->isPost()){
			Tag::setTitle('Authorization');
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
			$this->redirect();
		}
	}
	public function logoutAction(){
		$this->session->destroy();
		$this->redirect();
	}
}
