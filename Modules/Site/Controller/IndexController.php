<?php
namespace Modules\Site\Controller;
use Modules\Site\Model\Site;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
class IndexController extends \Library\Controller
{
	public function indexAction($id = 1){
		$site = Site::findFirst([
			'id = ?1 AND trash = "0"',
			'bind' => [1 => $id],
		]);

		if($site->module){
			$this->tag->setDescription($site->description);
			$this->tag->setKeywords($site->keywords);
			return $this->forward([
				'module' => $site->module,
				'controller' => $site->controller,
				'action' => $site->action,
				'params' => [],
			]);
		}else{

		}
	}
}
