<?php
namespace lib\Controller;

class_exists('lib\Service\Graph') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Service/Graph.php';
class_exists('lib\Service\OperationLog') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Service/OperationLog.php';


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
    
    public function __construct($post = null)
    {
        /** グラフ作成クラスのインスタンス*/
        $this->graph = new Graph();
    }
    
    
    /**
     * グラフを作成
     * @access public
     **/
    public function createGraph($val = null)
    {
        try {
            $result = false;
            if ($val) {
                $result = $this->graph->create($val["user"], $val["date"]);
                /** 結果がfalseの場合は*/
                if (!$result) {
                    throw new \exception("該当データがありません。");
                }
                $result = true;
            }
        } catch (\Exception $e) {
            $result = false;
            var_dump($e->getMessage());
        }finally{
            return $result;
        }
    }
    
    /**
     * グラフ情報の配列を取得し返す関数
     **/
    public function getgraphInfoPath_15()
    {
        return $this->graph->getgraphInfoPath_15();
    }
    
    /**
     * グラフ情報の配列を取得し返す関数
     **/
    public function getgraphInfoPath_60()
    {
        return $this->graph->getgraphInfoPath_60();
    }
    
    public function getwork()
    {
        return $this->graphInfo["work"];
    }
    
    public function getTotalWork()
    {
        return $this->graph->getTotalWork();
    }
}
