<?php
namespace Library;
class Tag extends \Phalcon\Tag {
	static public $description;
	static public $keywords = [];
	static public $bg_image = null;
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
	public function setBackground($bg_image){
		self::$bg_image = $bg_image;
	}
	public function getBackground(){
		return self::$bg_image;
	}
}
