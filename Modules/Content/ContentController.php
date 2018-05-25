<?php
namespace Modules\Content;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
class ContentController extends \Library\Controller{
	public function indexAction(){
		$builder = $this->modelsManager->createBuilder()
			->columns('c.id, c.name, c.description, DATE_FORMAT(c.created_dt, "%M %d, %Y") as created_dt,
				u.login as user_name')
			->addFrom('Modules\Content\Model\Content', 'c')
			->leftJoin('Modules\Users\Model\Users', 'c.user_id = u.id', 'u')
			->orderBy('c.created_dt');

		$this->view->paginator = (new PaginatorQueryBuilder([
				'builder' => $builder,
				'limit'   => 20,
				'page'    => $this->request->getQuery('page', 'int'),
			]))->getPaginate();
	}
	public function itemAction($id = null){
		if(isset($id)){
			$builder = $this->modelsManager->createBuilder()
				->columns('c.id, c.name, c.description, DATE_FORMAT(c.created_dt, "%M %d, %Y") as created_dt,
					u.login as user_name')
				->addFrom('Modules\Content\Model\Content', 'c')
				->leftJoin('Modules\Users\Model\Users', 'c.user_id = u.id', 'u')
				->andWhere('c.id = '.(int) $id);
		}
	}
}
