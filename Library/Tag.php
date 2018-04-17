<?php
namespace Library;
class Tag extends \Phalcon\Tag {
	static public $description;
	static public $keywords = [];
	public function setDescription($descr) {
		self::$description = $descr;
	}
	public function getDescription(){
		return self::$description;
	}
	public function setKeywords($keyword){
		self::$keywords[] = $keyword;
	}
	public function getKeywords(){
		return implode(', ',self::$keywords);
	}
}
