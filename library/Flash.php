<?php
namespace Library;
class Flash extends \Phalcon\Flash\Session{
	public function __construct()
	{
		$this->setCssClasses([
			'error'   => 'alert alert-danger hidden',
			'success' => 'alert alert-success hidden',
			'notice'  => 'alert alert-info hidden',
			'warning' => 'alert alert-warning hidden',
			]);
	}
}
