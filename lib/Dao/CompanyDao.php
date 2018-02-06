<?php
namespace lib\Dao;

class_exists('lib\Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';

class CompanyDao extends ParentDao
{

    public function get()
    {
        try {
                $qy = " SELECT * FROM pclog.company ";
                $result=parent::commitStmt($qy);
                return $result;
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {

        }
    }
}
