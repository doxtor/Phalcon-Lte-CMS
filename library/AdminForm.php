<?php
class AdminForm extends Phalcon\Forms\Form
{
	public function initialize($variables = null, $value = null) {
		if ($variables === null) return;
		foreach ($variables as $groups) {
			foreach ($groups as $name => $param) {
				unset($param['name']);
				$input = null;
				switch ($param['type']) {
					case 'text': $input = $this->input_text($name,$param);  break;
					case 'check': $input = $this->input_check($name,$param); break;
					case 'select': $input = $this->input_select($name,$param); break;
					case 'textarea': $input = $this->input_textarea($name,$param); break;
					case 'hidden':  $input = $this->input_hidden($name,$param); break;
					case 'file':$input = $this->input_file($name,$param); break;
					case 'date':$input = $this->input_date($name,$param); break;
					case 'numeric':$input = $this->input_numeric($name,$param); break;
					case 'password':$input = $this->input_password($name,$param); break;
				}
				if(isset($value->$name)){
					$input->setDefault($value->$name);
				}
				$this->add($input);
			}
		}
	}
	public function input_text($name,$param){
		$param['class'] = 'form-control';
		return new \Phalcon\Forms\Element\Text($name, $param);
	}
	public function input_check($name,$param){
		return new \Phalcon\Forms\Element\Check($name,$param);
	}
	public function input_select($name,$param){
		$param['class'] = 'form-control';
		$options = $param['options'];
		unset($param['options']);
		return new \Phalcon\Forms\Element\Select($name, $options, $param);
	}
	public function input_textarea($name,$param){
		$param['class'] = 'form-control';
		return new \Phalcon\Forms\Element\TextArea($name,$param);
	}
	public function input_hidden($name,$param){
		return new \Phalcon\Forms\Element\TextArea($name,$param);
	}
	public function input_file($name,$param){
		return new \Phalcon\Forms\Element\File($name,$param);
	}
	public function input_date($name,$param){
		$param['class'] = 'form-control';
		return new \Phalcon\Forms\Element\Date($name,$param);
	}
	public function input_numeric($name,$param){
		$param['class'] = 'form-control';
		return new \Phalcon\Forms\Element\Numeric($name,$param);
	}
	public function input_password($name,$param){
		$param['class'] = 'form-control';
		return new \Phalcon\Forms\Element\Password($name,$param);
	}
}
