<?php
namespace Library;
class MyPaginator implements \Phalcon\Paginator\AdapterInterface{
	/** @var Phalcon\Mvc\Model\Query\Builder $builder  */
	public $builder;
	public $limit;
	public $currentPage;
	public $totalCount;
	public $pagesCount;

	/**
	 * Конструктор адаптера
	 *
	 * @param array $config
	 * @throws \Phalcon\Exception
	 */
	public function __construct($config) {

		if (!isset($config['builder'])) {
			throw new \Phalcon\Exception('builder required parameter.');
		}

		if (!isset($config['limit'])) {
			throw new \Phalcon\Exception('limit required parameter.');
		}


		$this->builder = $config['builder'];
		$this->limit = (int) $config['limit'];

		if (isset($config['page'])) {
			$this->currentPage = (int) $config['page'];
		} else {
			$this->currentPage = 1;
		}


		if (isset($config['total'])) {
			$this->totalCount = (int) $config['total'];
		} else {
			$builder = clone($this->builder);
			$this->totalCount = $builder->columns(['COUNT(*) as countrow'])->getQuery()->execute()->getFirst()->countrow;
		}

		if ($this->totalCount < $this->limit) {
			$this->limit = $this->totalCount;
		}
	}

	/**
	 * Установка текущей страницы
	 * @param int $page
	 */
	public function setCurrentPage($page) {
		$this->currentPage = $page;
	}

	/**
	 * Установка Количество записей в одной странице
	 * @param int $limit
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
	}

	/**
	 * Возвращает количество записей в каждой странице
	 * @return mixed
	 */
	public function getLimit() {
		return $this->limit;
	}

	public function setQueryBuilder (Phalcon\Mvc\Model\Query\Builder $builder){
		$this->builder = $builder;
	}

	public function getQueryBuilder () {
		return $this->builder;
	}

	/**
	 * Считает общее количество страниц
	 */
	private function setPagesCount() {
	  if($this->limit){
		$this->pagesCount = ceil($this->totalCount / $this->limit);
	  }else{
		$this->pagesCount = 0;
	  }
	}

	/**
	 * Возвращает следующую страницу от текущего
	 * @return int|null
	 */
	public function getNextPage() {
		$nextPage = $this->currentPage + 1;

		if ($nextPage <= $this->pagesCount) {
			return $nextPage;
		}

		return $this->pagesCount;
	}

	/**
	 * Возвращает предыдущую страницу от текущего
	 * @return int|null
	 */
	private function getBeforePage() {
		$beforePage = $this->currentPage - 1;

		if ($beforePage >= 1) {
			return $beforePage;
		}

		return 1;
	}

	private function getItems() {
		$offset = $this->limit * ($this->currentPage - 1);
		$this->builder->offset($offset)->limit($this->limit);
		return $this->builder->getQuery()->execute();
	}

	/**
	 * Возвращает срез данных для вывода
	 *
	 * @return stdClass
	 */
	public function getPaginate() {
		$this->setPagesCount();
		$page = (object)[];
		$page->current = $this->currentPage;
		$page->before = $this->getBeforePage();
		$page->next = $this->getNextPage();
		$page->last = $this->pagesCount;
		$page->total_items = $this->totalCount;
		$page->total_pages = $this->pagesCount;
		$page->items = $this->getItems();
		return $page;
	}
}
