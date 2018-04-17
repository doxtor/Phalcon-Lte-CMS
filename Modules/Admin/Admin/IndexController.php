<?php
namespace Modules\Admin\Admin;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Model\Logger;
class IndexController extends \Library\AdminController
{
	public function indexAction()
	{
		if($this->request->isAjax()){
			$draw = (int) $this->request->getPost('draw');
			$start = (int) $this->request->getPost('start');
			$limit = (int) $this->request->getPost('length');

			if(!$limit) return;
			$currentPage = $limit ? ($start + $limit)/$limit : 1;

			$builder = $this->modelsManager->createBuilder()->columns('*');
			$builder->addFrom('Modules\Users\Model\Users');

			/*$search = $this->request->getPost('search');
			$search = $search['value'];
			if($search){
				$builder->orWhere('bl.phone LIKE "%'.$search.'%"');
				$builder->orWhere('bl.comment LIKE "%'.$search.'%"');
				$builder->orWhere('bl.hall_id = '.(int)$search);
			}

			$order = $this->request->getPost('order');
			$order = $order[0];
			switch($order['column']){
				default:case 0:$builder->orderBy('bl.added_at '.$order['dir']);break;
				case 1:$builder->orderBy('bl.phone '.$order['dir']);break;
				case 2:$builder->orderBy('bl.comment '.$order['dir']);break;
				case 3:$builder->orderBy('bl.hall_id '.$order['dir']);break;
			}*/

			$page = (new PaginatorQueryBuilder([
					'builder' => $builder,
					'limit' => $limit,
					'page'  => $currentPage,
				]))->getPaginate();
			$data = [
					'draw' => $draw,
					'recordsTotal' => $page->total_items,
					'recordsFiltered' => $page->total_items
				];
			$i = 0; $data['data'] = [];
			foreach ($page->items as $item) {
				$data['data'][$i][] = $item->id;
				$data['data'][$i][] = $item->name;
				$data['data'][$i][] = '<a href="/black/delete/'.$item->id.'"'
					. 'title="Удалить" onclick="return confirm(\'Вы уверены?\');" class="btn btn-default">'
					. '<i class="fa fa-trash"></i></a>';
				$i++;
			}
			$this->response->setContentType('application/json', 'UTF-8');
			$this->response->setJsonContent($data);
		}else{
			$this->tag->setTitle('Черный список');
		}
	}
}
