<?php
namespace Form;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\{Text, TextArea, Hidden};
class UsersForm extends Form
{
	/**
	* Инициализация формы для добовление в черный список.
	*/
	public function initialize()
	{
		$this->add(new Hidden($this->security->getTokenKey(),[
				'value' => $this->security->getToken()
			]));
		$this->add(new TextArea('phones',[
				'class' => 'form-control',
				'required' => true,
				'rows' => 3,
				'placeholder' => 'Введите телефоны через запятую'
			]));
		$this->add(new TextArea('comment',[
				'class' => 'form-control',
				'rows' => 8,
				'placeholder' => 'Введите комментарий'
			]));

	}
}
