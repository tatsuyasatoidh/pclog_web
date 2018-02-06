<?php
namespace lib\Dao;

class_exists('lib\Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';
class_exists('lib\Entity\Pclog') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Entity/Pclog.php';

use lib\Entity\Pclog as Pclog;

class PclogDao extends ParentDao
{

    private $table = "pclog";
    
    function __construct()
    {
        $pclogEntity = new Pclog();
    }
    
    function getAll()
    {
        parent::setInfoLog("getAll START");
        try {
            $qy = "  SELECT * FROM pclog ";
            $qy .= " JOIN user ON pclog.user_id = user.id ";
            $qy .= " JOIN company ON user.company_id = company.id";
            $qy .= " GROUP BY pclog.date,pclog.user_id,user.user_name,company.company_name";
            $result=parent::commitStmt($qy);
            parent::setInfoLog("commit Sql : $qy");
            return $result;
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            parent::setInfoLog("getAll END");
        }
    }
    
    function getAllWhere($company, $user, $start, $end)
    {
        try {
                    parent::setInfoLog("getAllWhere START");
            $qy = " SELECT pclog.id,
            pclog.date,
            pclog.user_id,
            pclog.number_of_work,
            user.user_name,
            user.company_id,
            company.company_name
            FROM pclog ";
            $qy .= " JOIN user ON pclog.user_id = user.id ";
            $qy .= " JOIN company ON user.company_id = company.id";
            if (isset($company) or isset($user) or isset($start) or isset($end)) {
                $qy .=" WHERE 1=1";
                if ($company!="") {
                    $qy .=" AND company.id = '$company'";
                }
                if ($user!="") {
                    $qy .=" AND user.id = '$user' ";
                }
                if ($start!="") {
                    $qy .=" AND pclog.date >='". $start ."'";
                }
                if ($end!="") {
                    $qy .=" AND pclog.date <='". $end ."'";
                }
            }
            
            parent::setInfoLog($qy);
            $result=parent::commitStmt($qy);
            return $result;
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            parent::setInfoLog("getAllWhere END");
        }
    }
    
    function getByCompanyId($companyId)
    {
        try {
                    parent::setInfoLog("getAllWhere START");
            $qy = "SELECT pclog.id,
            pclog.date,
            pclog.user_id,
            pclog.number_of_work,
            user.user_name,
            user.company_id,
            company.company_name
            FROM pclog 
						JOIN user 
						ON pclog.user_id = user.id 
						JOIN company ON user.company_id = company.id 
						AND company.id = '$companyId'";
            parent::setInfoLog($qy);
            $result=parent::commitStmt($qy);
            return $result;
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            parent::setInfoLog("getAllWhere END");
        }
    }
    
    /**
     *月間ログをSELECT
     * @access public
     * @param $userId
     * @param $Ym
     */
    public function getMonthLog($userID, $Ym)
    {
        try {
                parent::setInfoLog("getMonthLog START");
                $qy = "SELECT * FROM pclog WHERE date_format(date, '%Y%m') = '$Ym' AND user_id = $userID GROUP BY DATE(`date`)";
                parent::setInfoLog($qy);
                $result=parent::commitStmt($qy);
        } catch (Exception $e) {
                echo $e;
                die($e);
        } finally {
            parent::setInfoLog("getMonthLog END");
            return $result;
        }
    }
}
