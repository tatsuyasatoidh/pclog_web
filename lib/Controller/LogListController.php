<?php
namespace lib\Controller;

include_once dirname(__FILE__)."/../mysql/ConnectMysql.php";
class_exists('lib\Dao\PclogDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/PclogDao.php';
class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';
class_exists('lib\Entity\User') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Entity/User.php';

use lib\Dao\PclogDao as PclogDao;
use lib\Entity\User as User;

class LogListController extends ParentController
{
    
    /** post*/
    private $companyid;
    private $user;
    private $start_date;
    private $end_date;
    
    /** 結果　loglist array*/
    private $logListArray = [];
    const DOWNLOAD_LOG_FILE = "/lib/Controller/Download/getLogCsv.php";
  
  /**
   * コンストラクタ
   * @access public
   **/
    public function __construct($userId = null)
    {
        /** ユーザーIDから企業IDを取得。IDH以外は自分の所属企業しか取得しない*/
        $this->loginUser = new User($userId);
    }
    
  /**
   * postの値を使ってlog一覧をmysqlから取得
   * @access private
     * @return
   **/
    private function getByPost($post)
    {
        parent::setInfoLog("getByPost START");
        /** Daoインスタンスの作成*/
        $PclogDao = new PclogDao();
        $result =$PclogDao->getAllWhere($post['company'], $post['user'], $post['start_date'], $post['end_date']);
        parent::setInfoLog("getByPost END");
        return $result;
    }
    
    function noData()
    {
        echo "該当データは0件です。";
    }
    
    /**
     * 抽出結果を取得する関数
     * @return array 抽出結果
     */
    public function getResult()
    {
        return $this->logListArray;
    }
    
    /**
     * ログ一覧リストを取得
     *
     **/
    public function getLogList($post = null)
    {
        try {
            $PclogDao = new PclogDao();
            if ($post != null) {
                /** postの値を使ってmysqlから一覧を取得*/
                if ($this->loginUser->getPermition() =="ALL") {
                    $this->logListArray=$PclogDao->getAllWhere($post['company'], $post['user'], $post['start_date'], $post['end_date']);
                } else {
                    /** 所属企業のログのみ取得*/
                    $this->logListArray=$PclogDao->getAllWhere($this->loginUser->getCompanyId(), $post['user'], $post['start_date'], $post['end_date']);
                }
            } else {
                /** ログインユーザーの権限を確認*/
                if ($this->loginUser->getPermition() =="ALL") {
                    /** 条件なしにすべてのログを取得*/
                    $this->logListArray=$PclogDao->getAll();
                } else {
                    /** 所属企業のログのみ取得*/
                    $this->logListArray=$PclogDao->getByCompanyId($this->loginUser->getCompanyId());
                }
            }
            $result = $this->createLogListTable($this->logListArray);
        } catch (\Exception $e) {
            parent::setInfoLog("FAILED to getLogList");
            $result = false;
        }finally{
            parent::setInfoLog("getLogList END");
            return $result;
        }
    }
    
    /**
     * ログ一覧テーブルを作成
     */
    private function createLogListTable($logListArray)
    {
        parent::setInfoLog("createLogListTable START");
        try {
            $tbody = "<table id='log_table' style='width: 100%;'>";
            $tbody .= "<tbody>";
            $tbody .="<tr><th>取得日</th><th>企業名</th><th>ユーザー</th><th>作業数</th><th>ログファイル</th></tr>";
            if (!$logListArray) {
                throw new \exception("検索結果は0件です");
            }
            $row =0;
            foreach ($logListArray as $logInfo) {
                $funcPath=self::DOWNLOAD_LOG_FILE;
                $path="log/".$logInfo['company_id']."/".$logInfo['user_id']."/log_".date('Ymd', strtotime($logInfo['date']));
                $href=$funcPath."/?log_path=".$path;

                $tbody .= "<tr>";
                $tbody .= "<td>".$logInfo["date"]."</td>";
                $tbody .= "<td>".$logInfo["company_name"]."</td>";
                $tbody .= "<td>".$logInfo["user_name"]."</td>";
                $tbody .= "<td>".$logInfo["number_of_work"]."</td>";
                $tbody .= "<td><a href='$href'>ログファイル(.csv)</a> <a href='$href'>ログファイル(.tsv)</a></td>";
                $tbody .= "</tr>";
                $row++ ;
            }
            $tbody .= "</tbody>";
            $tbody .= "</table>";
            if (!$row) {
                throw new \exception("検索結果は0件です");
            }
        } catch (\Exception $e) {
            parent::setInfoLog($e->getMessage());
            $tbody = false;
        }finally{
            parent::setInfoLog("createLogListTable END");
            return $tbody;
        }
    }
}
