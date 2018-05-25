<?php
namespace Modules\Site;

use Modules\Site\Model\Site;

class PhoneController extends \Library\AdminController{
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
				'options' => [
					ContactEmail::STATUS_NOT_CONFIRMED => 'Не подтвежден',
					ContactEmail::STATUS_BLOCKED => 'Заблокирован',
					ContactEmail::STATUS_ACTIVE => 'Активен',
				]
			]
		]
	];

	public $list = [
		'phone' => [
			'name' => 'Номер телефона',
			'sql' => true
		],

		'status' => [
			'name' => 'Статус',
			'type' => 'select',
			'options' => [
				ContactEmail::STATUS_NOT_CONFIRMED => 'Не подтвежден',
				ContactEmail::STATUS_BLOCKED => 'Заблокирован',
				ContactEmail::STATUS_ACTIVE => 'Активен',
			],
			'sql' => true
		],
	];
}