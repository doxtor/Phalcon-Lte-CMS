<?php
namespace Library;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Phalcon\Tag;
use Library\Paginator;
class AdminController extends Controller{
	public $title = 'Title';
	public $table;
	public $form;
	public $variables;
	public $list;
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
	}
	public function indexAction(){}
	public function listAction(){
		$columns = [];
		foreach ($this->list as $key => $value) {
			if(isset($value['sql']) && $value['sql']){
				$columns[] = $key;
			}
		}
		$builder = $this->modelsManager->createBuilder()
					->columns($columns)
					->from($this->table);
		$this->view->paginator = (new PaginatorQueryBuilder([
				'builder' => $builder,
				'limit'   => 20,
				'page'    => 1,
			]))->getPaginate();
		$this->view->setLayout('list');
		$model = $this->table;
		$this->view->primary_key_name = $model::PRIMARY_KEY;
		$this->view->list = $this->list;
		$this->view->edit_link = $this->url->get([
			'for' => 'default',
			'module' => $module,
			'controller' => $this->router->getControllerName(),
			'action' => 'edit'
		]);
		Tag::setTitle($this->title);
	}
	public function editAction($primaryKeyValue = null){
		$model = $this->table;
		$primaryKeyName = $model::PRIMARY_KEY;
		$primaryKeyValue = $this->filter->sanitize($primaryKeyValue, 'int');

		parent::_edit();
		parent::setTitle($this->getModuleTitle());

		$columns = [];
		foreach ($this->variables as $key => $value) {
			foreach ($value as $col => $val) {
				$columns[] = $col;
			}
		}

		$value = null;

		if (isset($primaryKeyValue)) {
			$value = $this->modelsManager
				->createBuilder()
				->columns($columns)
				->addFrom($this->table)
				->where( $primaryKeyName . ' = :' . $primaryKeyName . ':', [$primaryKeyName => $primaryKeyValue])
				->getQuery()
				->execute()
				->getFirst();
		}

		$this->renderForm($value, $primaryKeyValue);
	}
	public function saveAction($primaryKeyValue = null) {
		$columns = [];
		$values = [];
		$modelClass = $this->table;
		$primaryKeyName = $modelClass::PRIMARY_KEY;
		$primaryKeyValue = $this->filter->sanitize($primaryKeyValue, 'int');

		if ($this->request->isPost()) {
			foreach ($this->variables as $key => $value) {
				foreach ($value as $col => $val) {
					$columns[] = $col;
					$value = $this->request->getPost($col);
					$values[$col] = $value ? $value : '0';
				}
			}

			$modelClass = $this->table;
			if (empty($primaryKeyValue)){
				$model = new $modelClass();
				$model->assign($values, null, $columns);
				if ($model->create() === false) {
					$this->publishErrorMessages($model);
					$this->renderForm($model);
					return false;
				}
			} else {
				$model = $modelClass::findFirstByFields([$primaryKeyName => $primaryKeyValue]);
				$model->assign($values, null, $columns);
				if ($model->update() === false) {
					$this->publishErrorMessages($model);
					$this->renderForm($model, $primaryKeyValue);
					return false;
				}
			}

			$this->response->redirect($this->url->get([
				'for' => 'default',
				'module' => $this->router->getModuleName(),
				'controller' => $this->router->getControllerName(),
				'action' => 'list'
			]));

		}
		return true;
	}
	public function sortAction() {
		$this->view->disable();
		$modelClass = $this->table;
		$primaryKeyName = $modelClass::PRIMARY_KEY;
		$ids = $this->request->getPost('ids');
		$orderColumnName = $this->list['actions']['orderColumnName'];
		$idArgs = implode(', ',  array_map(function($value) { return '?' . $value; }, array_keys($ids)));

		$items = $this->modelsManager
			->createBuilder()
			->columns([$primaryKeyName, $orderColumnName])
			->addFrom($this->table)
			->where($primaryKeyName . ' IN (' . $idArgs . ')', $ids)
			->orderBy($orderColumnName)
			->getQuery()
			->execute();

		if (count($items)) {
			$minOrder = $items->getFirst()->$orderColumnName;

			foreach ($items as $item) {
				$id = $item->$primaryKeyName;
				$newPosition = array_search($id, $ids) + $minOrder;

				if ($item->$orderColumnName != $newPosition) {
					$this->db->update(
						$modelClass::getSource(),
						[$orderColumnName],
						[$newPosition],
						$primaryKeyName . ' = ' . $id
					);
				}

			}
		}
	}
	private function renderForm($entity = null, $primaryKeyValue = null) {
		if (isset($primaryKeyValue)) {
			$this->view->save_link = $this->url->get([
				'for' => 'default',
				'module' => $this->router->getModuleName(),
				'controller' => $this->router->getControllerName(),
				'action' => 'save',
				'params' => $primaryKeyValue
			]);
		} else {
			$this->view->save_link = $this->url->get([
				'for' => 'default',
				'module' => $this->router->getModuleName(),
				'controller' => $this->router->getControllerName(),
				'action' => 'save'
			]);
		}

		$this->view->form = new \AdminForm();
		$this->view->form->initialize($this->variables, $entity);
		$this->view->variables = $this->variables;
		$this->view->setLayout('edit');
	}
	public function redirect($location = null, $externalRedirect = false, $statusCode = 302){
		if(!isset($location)){
			$location = $this->config->get('admin')->get('url');
		}elseif(is_string($location)){
			$location = $this->config->get('admin')->get('url') . '/' . $location;
		}
		$this->response->redirect($location, $externalRedirect, $statusCode);
	}
}
