<?php
namespace lib\HttpRequest;

class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';

use lib\Controller\ParentController as ParentController;

class FormValue extends ParentController{

	private $company;
	private $user;
	private $date;
	private $type;
	
	public function __construct($post)
	{
		foreach ($post as $key =>$value)
		{
			$this->$key = $value;
			parent::setInfoLog("[$key] is ".$this->$key);
		}
	}
	
}
