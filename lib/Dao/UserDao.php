<?php
include_once dirname(__FILE__).'/../Common/AbstractDao.php';

class UserDao extends AbstractDao {

    public function get()
    {
    try {
            $qy = " SELECT * FROM pclog.user ";
            $result=parent::commitStmt($qy);
            return $result;
        } catch ( Exception $e ) {
           echo $e;
           die ( $e );
        } finally {

        }
    } 
}