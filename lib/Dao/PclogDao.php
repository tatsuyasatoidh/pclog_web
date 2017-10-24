<?php
namespace lib\Dao;

class_exists('lib\Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';
class_exists('lib\Entity\Pclog') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Entity/Pclog.php';

use lib\Entity\Pclog as Pclog;

class PclogDao extends ParentDao{

    private $table = "pclog";
    
    function __construct(){
        $pclogEntity = new Pclog();
    }
    
	function getAll(){
		parent::setInfoLog("getAll START");
		try {
			$qy = " SELECT * FROM pclog ";
			$qy .= " JOIN user ON pclog.user_id = user.id ";
			$qy .= " JOIN company ON 1 = 1";
			$qy .= " GROUP BY pclog.date,pclog.user_id,user.user_name,company.company_name";
			$result=parent::commitStmt($qy);
			parent::setInfoLog("commit Sql : $qy");
			return $result;
		} catch ( Exception $e ) {
			echo $e;
			die ( $e );
		} finally {
			parent::setInfoLog("getAll END");
		}
	}
    
    function getAllWhere($company, $user, $start, $end ){
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
            if( isset($company) or isset($user) or isset($start) or isset($end) ){
                $qy .=" WHERE 1=1";
                if($company!=""){
                    $qy .=" AND company.id = '$company'";
                }
                if($user!=""){
                    $qy .=" AND user.id = '$user' ";
                }
                if($start!=""){
                    $qy .=" AND pclog.date >='". $start ."'";
                }
                if($end!=""){
                    $qy .=" AND pclog.date <='". $end ."'";                    
                }        
            }
            
            parent::setInfoLog($qy);
            $result=parent::commitStmt($qy);
            return $result;
 
        } catch ( Exception $e ) {
            echo $e;
            die ( $e );
        } finally {
       parent::setInfoLog("getAllWhere END");
        }
    }
}
