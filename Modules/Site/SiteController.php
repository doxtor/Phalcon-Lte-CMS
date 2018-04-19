<?php
namespace Modules\Site;
use Modules\Site\Model\Site;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
class SiteController extends \Library\Controller
{
	public function indexAction($id = 1){
		$site = Site::findFirst([
			'id = ?1 AND trash = "0"',
			'bind' => [1 => $id],
		]);

		if(isset($site->module)){
			$this->tag->setDescription($site->description);
			$this->tag->setKeywords($site->keywords);
			return $this->forward([
				'controller' => $site->controller,
				'action' => $site->action,
				'params' => json_decode($site->params),
			]);
		}else{

		}
	}
}
