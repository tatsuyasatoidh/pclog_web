<?php
include_once dirname(__FILE__).'/../Common/AbstractDao.php';
include_once dirname(__FILE__).'/../Entity/pclog.php';

class pclogDao extends AbstractDao{

    private $table = "pclog";
    
    function __construct(){
        $pclogEntity = new pclog();
    }
    
    function getAll(){
    try {
        $qy = " SELECT pclog.id,pclog.date,pclog.user_id,pclog.number_of_work,user.user_name,company.company_name FROM pclog ";
        $qy .= " JOIN user ON pclog.user_id = user.id ";
        $qy .= " JOIN company ON 1 = 1";
        $qy .= " GROUP BY pclog.date,pclog.user_id,user.user_name,company.company_name";
        $result=parent::commitStmt($qy);
        parent::setInfoLog($qy);
        return $result;

    } catch ( Exception $e ) {
        echo $e;
        die ( $e );
    } finally {

    }
    }
    
    function getAllWhere($company, $user, $start, $end ){
        try {
            $qy = " SELECT * FROM pclog ";
            $qy .= " JOIN user ON pclog.user_id = user.id ";
            $qy .= " JOIN company ON user.company_id = company.id";
            if( isset($company) or isset($user) or isset($start) or isset($end) ){
                $qy .=" WHERE 1=1";
                if($company!=""){
                    $qy .=" AND company.company_name = '$company'";
                }
                if($user!=""){
                    $qy .=" AND user.user_name = '$user' ";
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
       
        }
    }
}
