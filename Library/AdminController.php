<?php
namespace Library;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Phalcon\Tag;
use Library\{Paginator, AdminForm};
class AdminController extends Controller{
	public $title = 'Title';
	public $module = 'core';
	public $controller = 'index';
	public $table;
	public $form;
	public $variables;
	public $columns = [];
	public $builder;
	public $limit = 10;
	public function beforeExecuteRoute($dispatcher){
		if(!$this->session->get('role') && !(
			$dispatcher->getModuleName() === 'users' &&
			$dispatcher->getControllerName() === 'users' &&
			$dispatcher->getActionName() === 'login'
		)){
			$this->forward([
				'module'     => 'users',
				'controller' => 'users',
				'action'     => 'login',
				'params' => [],
			]);
		}
		$this->module = $dispatcher->getModuleName();
		$this->controller = $dispatcher->getControllerName();
	}
	public function indexAction(){}
	public function listAction(){
		$columns = [];
		foreach ($this->columns as $key => $value) {
			if(isset($value['sql']) && $value['sql']){
				$columns[] = $key;
			}
		}
		$model = $this->table;
		if($this->request->isAjax()){
			$start = $this->request->getPost('start', 'int', 0);
			$length = $this->request->getPost('length', 'int', 10);
			$builder = $this->modelsManager->createBuilder()
				->columns($columns)
				->from($this->table);

			/*if($search_type_log = $this->request->getQuery('search_type_log')){
				$builder->andWhere('l.type IN('.$search_type_log.')');
			}
			$search = $this->request->getPost('search');
			$search = $search['value'];
			if($search){
				$builder->andWhere('l.content LIKE "%'.$search.'%"');
			}*/
			$order = $this->request->getPost('order')[0];
			if(isset($order['column']) && isset($columns[$order['column']]))
				$builder->orderBy($columns[$order['column']] . ' ' . $order['dir']);

			$page = (new PaginatorQueryBuilder([
					'builder' => $builder,
					'limit' => $length,
					'page'  => ($length ? ($start + $length)/$length : 1),
				]))->getPaginate();
			$data = [
					'draw' => $this->request->getPost('draw', 'int', 1),
					'recordsTotal' => $page->total_items,
					'recordsFiltered' => $page->total_items
				];
			$i = 0; $data['data'] = [];
			foreach ($page->items as $item) {
				foreach ($this->columns as $key => $value) {
					if(isset($value['sql'])){
						$data['data'][$i][] = $item->$key ?? '';
					}
					if($key == 'actions'){
						$action = '';
						if(isset($value['edit']))
							$action .= '<a href="'
							. $this->url(['action' => 'edit', 'id' => $item->id])
							. $item->id . '"><i class="fas fa-edit"></i></a>';
						if(isset($value['delete']))
							$action .= '<a href="'
							. $this->url(['action' => 'delete', 'id' => $item->id])
							. $item->id . '"><i class="fas fa-trash-alt"></i></a>';
						$data['data'][$i][] = $action;
					}
				}
				$i++;
			}
			$this->response->setContentType('application/json', 'UTF-8');
			$this->response->setJsonContent($data);
		}else{
			$this->view->columns = $this->columns;
			Tag::setTitle($this->title);
			$this->view->setLayout('list');
		}
	}
	public function editAction($id = null){
		Tag::setTitle($this->title);
		$model = $this->table;
		$id = $this->filter->sanitize($id, 'int');

		$columns = [];
		foreach ($this->variables as $key => $value) {
			foreach ($value as $col => $val) {
				$columns[] = $col;
			}
		}
		$value = null;
		if (isset($id)) {
			$value = $model::findFirst([
				'columns' => $columns,
				'conditions' => 'id = ?0',
				'bind' => [$id]
			]);
		}
		$this->renderForm($value, $id);
	}
	public function saveAction($id = null) {
		$id = $this->filter->sanitize($id, 'int');
		if ($this->request->isPost()) {
			$columns = [];$values = [];
			foreach ($this->variables as $key => $value) {
				foreach ($value as $col => $val) {
					$columns[] = $col;
					$value = $this->request->getPost($col);
					$values[$col] = $value ? $value : '0';
				}
			}
			$model = $this->table;
			if (!isset($id)){
				$model = new $model();
				$item->assign($values, null, $columns);
				if ($item->create() === false) {
					$this->publishErrorMessages($item);
					$this->renderForm($item);
					return false;
				}
			} else {
				$item = $model::findFirst([
					'conditions' => 'id = ?0',
					'bind' => [$id]
				]);
				try{
					if($item->save($values) === false){
						echo 'da';
						exit();
					}
				} catch(\Exception $e){
					echo $e->getMessage();
					exit();
				}
				$item->name = $values['name'];
				if($item->save() === false){
					echo 'error';
				}else{
					echo 'ok';
				}
				exit();

				if ($item->save($values) === false) {
					$this->publishErrorMessages($item);
					$this->renderForm($item, $id);
					return false;
				}
			}
			$this->response->redirect($this->url(['action' => 'list']));
		}
	}
	private function renderForm($value = null, $id = null) {
		if(isset($id)){
			$params = ['action' => 'save', 'params' => $id];
		}else{
			$params = ['action' => 'save'];
		}
		$this->view->save_link = $this->url($params);
		$this->view->form = new AdminForm();
		$this->view->form->initialize($this->variables, $value);
		$this->view->variables = $this->variables;
		$this->view->setLayout('edit');
	}
	public function url($params = []){
		return '/admin' . $this->url->get(
			array_merge([
			'for' => 'default',
			'module' => $this->module,
			'controller' => $this->controller],
			$params)
		);
	}
	public function redirect($location = null, $externalRedirect = false, $statusCode = 302){
		if(!isset($location)){
			$location = $this->config->get('admin')->get('url');
		}elseif(is_string($location)){
			$location = $this->config->get('admin')->get('url') . '/' . $location;
		}
		$this->response->redirect($location, $externalRedirect, $statusCode);
	}
	public function publishErrorMessages($entity) {
		foreach ($entity->getMessages() as $message) {
			$this->flash->error($message);
		}
	}
}
