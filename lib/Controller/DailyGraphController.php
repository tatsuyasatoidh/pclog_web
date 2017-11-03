<?php
namespace lib\Controller;

class_exists('lib\Controller\Form\FormController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/Form/FormController.php';
class_exists('lib\Service\Graph') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Service/Graph.php';
class_exists('lib\Service\OperationLog') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Service/OperationLog.php';

use lib\Controller\Form\FormController as FormController;
use lib\Service\Graph as Graph;
use lib\Service\OperationLog as OperationLog;

/**
 * 日別グラフコントローラ
 **/
class DailyGraphController
{
	/** エラーメッセージ*/
	private $errorMessage = [];
	private $graphInfo = [];
	
	private $graph;
	
	public function __construct()
	{
		/** グラフ作成クラスのインスタンス*/
		$this->graph = new Graph();
	}
	
	/** ユーザー選択肢を表示する*/
	public function displayUserOption()
	{
		$formController = new FormController();
		return $formController->getUserOption();
	}

	/** 企業名選択肢を表示する*/
	public function displayCompanyOption()
	{
		$formController = new FormController();
		return $formController->getCompanyOption();
	}
	
	/**
	 * グラフを作成
	 * @access public 
	 **/
	public function createGraph($val = null)
	{
			try{
				$result = false;
				if($val){
					$result = $this->graph->create($val["company"],$val["user"],$val["date"],$val["type"]);
					/** 結果がfalseの場合は*/
					if(!$result){
						throw new \exception("該当データがありません。");
					}
					$result = true;
				}
			}catch(\Exception $e){
				$result = false;
				var_dump($e->getMessage());
			}finally{
				return $result;
			}	
		}
	
	/**
	 * グラフ情報の配列を取得し返す関数
	 **/
	public function getGraphInfo()
	{
		return $this->graph->getGraphINfoPathArray();
	}
	
	public function getwork()
	{
		return $this->graphInfo["work"];
	}
	
	
}