<?php
include_once dirname(__FILE__).'/../Common/AbstractDao.php';

class CompanyDao extends AbstractDao {

    public function getCompanyName()
    {
        try {
                $qy = " SELECT company_name FROM pclog.company ";
                $result=parent::commitStmt($qy);
                return $result;
            } catch ( Exception $e ) {
               echo $e;
               die ( $e );
            } finally {

            }
    } 
}