<?php
namespace Modules\Site;

use Modules\Site\Model\Site;

class SiteAdmin extends \Library\AdminController{
	public $title = 'Site pages';
	public $table = 'Modules\Site\Model\Site';
	public $variables = [
		'' => [
			'name' => [
				'name' => 'Name',
				'type' => 'text',
			],
			'rewrite' => [
				'name' => 'Rewrite',
				'type' => 'text',
			],
			'text' => [
				'name' => 'Text',
				'type' => 'textarea',
			],
		]
	];
	public $columns = [
		'id' => [
			'name' => 'ID',
			'sql' => true,
		],
		'name' => [
			'name' => 'Name',
			'sql' => true,
		],
		'rewrite' => [
			'name' => 'Rewrite',
			'sql' => true,
		],
		'actions' => [
			'name' => 'Actions',
			'edit' => true,
			'delete' => true,
		],
	];
}
