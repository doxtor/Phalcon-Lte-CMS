<?php
namespace Admin\Controller;
use RB\AuthManager;
use \Admin\Model\User;

/**
 * Class SecurityController
 * @property \Auth $auth
 * @package User\Controller
 */
class UserController extends \AdminController
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
					User::STATUS_ACTIVE => 'Активен',
					User::STATUS_INACTIVE => 'Не активен',
				]
			],
			'is_banned' => [
				'name' => 'Заблокирован?',
				'type' => 'select',
				'options' => [
					User::IS_BANNED_NO => 'Нет',
					User::IS_BANNED_YES => 'Да',
				]
			],
			'is_deleted' => [
				'name' => 'Удален?',
				'type' => 'select',
				'options' => [
					User::IS_BANNED_NO => 'Нет',
					User::IS_BANNED_YES => 'Да',
				]
			],
			'is_publish_false_offer' => [
				'name' => 'Пользователь публикует замануху?',
				'type' => 'select',
				'options' => [
					User::IS_BANNED_NO => 'Нет',
					User::IS_BANNED_YES => 'Да',
				]
			],
		],
		'Права пользователя' => [
			'id_group' => [
				'name' => 'Роль в системе',
				'type' => 'select',
				'options' => [
					AuthManager::ADMIN_ROLE => 'Администратор',
					AuthManager::MODERATOR_ROLE => 'Модератор',
					AuthManager::USER_ROLE => 'Пользователь'
				]
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
		'id_group' => [
			'name' => 'Роль в системе',
			'type' => 'select',
			'options' => [
				AuthManager::ADMIN_ROLE => 'Администратор',
				AuthManager::MODERATOR_ROLE => 'Модератор',
				AuthManager::USER_ROLE => 'Пользователь'
			],
			'sql' => true
		],

	];


}
