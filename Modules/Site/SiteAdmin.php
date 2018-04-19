<?php
namespace Modules\Site;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
class SiteAdmin extends \Library\AdminController
{
	public function index()
	{
		if($this->request->isAjax()){
			$limit = $this->request->getPost('length', 'int');
			$page = $limit ? ($this->request->getPost('start', 'int') + $limit)/$limit : 1;

			$builder = $this->modelsManager->createBuilder()->addFrom('Modules\Users\Model\Users');
			$paginator = (new PaginatorQueryBuilder([
					'builder' => $builder,
					'limit' => $limit,
					'page'  => $page,
				]))->getPaginate();
			$data = [
					'data' => [],
					'draw' => $this->request->getPost('draw', 'int'),
					'recordsTotal' => $paginator->total_items,
					'recordsFiltered' => $paginator->total_items
				];
			$i = 0;
			foreach ($paginator->items as $item) {
				$data['data'][$i][] = $item->id;
				$data['data'][$i][] = $item->name;
				$data['data'][$i][] = '<a href="/black/delete/' . $item->id . '"'
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
