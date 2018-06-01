<?php
namespace Modules\Site;

use Modules\Site\Model\Site;

class SiteAdmin extends \Library\AdminController{
	public $title = 'Site pages';
	public $table = 'Modules\Site\Model\Site';
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

	public $list = [
		'id' => [
			'name' => 'ID',
			'sql' => true,
		],
		'name' => [
			'name' => 'Название',
			'sql' => true,
		],
		'actions' => [
			'sortable' => true,
			'orderColumnName' => 'sort',
		],
	];
}
