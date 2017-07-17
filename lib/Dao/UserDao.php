<?php
include_once dirname(__FILE__).'/../Common/AbstractDao.php';

class UserDao extends AbstractDao {

    public function getUserName()
    {
        try {
                $qy = " SELECT user_name FROM pclog.user ";
                $result=parent::commitStmt($qy);
                return $result;
            } catch ( Exception $e ) {
               echo $e;
               die ( $e );
            } finally {

            }
    } 
}