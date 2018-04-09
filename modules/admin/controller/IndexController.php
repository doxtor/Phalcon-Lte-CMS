<?php
namespace Admin\Controller;
use Model\Logger;
class IndexController extends \Library\AdminController
{
	public $table = 'User\Model\User';
	public $variables = [
		'Основные данные' => [
			'id' => [
				'type' => 'text',
				'name' => 'ID',
			],
			'status' => [
				'name' => 'Статус',
				'type' => 'select',
				'options' => [
					'a'=> 'Активен',
					'n' => 'Не активен',
				]
			],
			'is_banned' => [
				'name' => 'Заблокирован?',
				'type' => 'select',
				'options' => [

				]
			],
			'is_deleted' => [
				'name' => 'Удален?',
				'type' => 'select',
				'options' => [

				]
			],
			'is_publish_false_offer' => [
				'name' => 'Пользователь публикует замануху?',
				'type' => 'select',
				'options' => [

				]
			],
		],
		'Права пользователя' => [
			'id_group' => [
				'name' => 'Роль в системе',
				'type' => 'select',
				'options' => []
			],
		]
	];
	public $list = [
		'id' => [
			'name' => 'Идентификатор',
			'sql' => true
		],

		'login' => [
			'name' => 'Фамилия',
			'sql' => true
		],

		'name' => [
			'name' => 'Имя',
			'sql' => true
		],
	];
}
