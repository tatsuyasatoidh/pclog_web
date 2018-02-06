<?php
namespace lib\Dao;

class_exists('lib\Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';

use lib\Dao\ParentDao as ParentDao;

class UserDao extends ParentDao
{

    public function get()
    {
        try {
            parent::setInfoLog("get START");
            $result = "";
            $qy = " SELECT * FROM pclog.user ";
            $result=parent::commitStmt($qy);
        } catch (Exception $e) {
            echo $e;
        } finally {
            parent::setInfoLog("get END");
            return $result;
        }
    }
    
    /**
    * userIdを使用してレコードを取得する
    * @access public
    * @return string 操作ユーザー名
    **/
    public function getByUserId($userId)
    {
        try {
            parent::setInfoLog("getByUserId START");
            $qy = " SELECT * FROM pclog.user WHERE id = '${userId}'";
            $row=parent::commitStmt($qy);
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            parent::setInfoLog("getByUserId END");
            return $row;
        }
    }

 /**
    * userIdを使用してレコードを取得する
    * @access public
    * @return string 操作ユーザー名
    **/
    public function getByCompanyId($companyId)
    {
        try {
            parent::setInfoLog("getByUserId START");
            $qy = " SELECT * FROM pclog.user WHERE id = '${companyId}'";
            $row=parent::commitStmt($qy);
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            parent::setInfoLog("getByUserId END");
            return $row;
        }
    }
    
    /**
     * メールアドレスとパスワードを指定してレコードが存在するか確認する。
     * @access public
     * @return string 操作ユーザー名
     **/
    public function getIdByEmailAndPassword($email, $passWord)
    {
        try {
            $result = false;
            $qy = " SELECT id FROM pclog.user WHERE mail_address ='${email}' AND password ='${passWord}'";
            parent::setInfoLog("commit Sql : $qy");
            $row=parent::commitStmt($qy);
        
            foreach ($row as $value) {
                $result = $value[0];
                parent::setInfoLog("Sql result : $result");
            }
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            return $result;
        }
    }
    
    /**
    * メールアドレスがMysqlに登録されているかを確認
    * @access public
    * @return boolean
    **/
    public function checkEmail($email)
    {
        try {
                    $result = false;
                    $qy = " SELECT COUNT(*) FROM pclog.user WHERE mail_address ='${email}'";
                    parent::setInfoLog("commit Sql : $qy");
                    $row=parent::commitStmt($qy);

            foreach ($row as $value) {
                $result = $value[0];
                parent::setInfoLog("Sql result : $result");
            }
            if ($result > 0) {
                $result = true;
            } else {
                $result = false;
            }
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            return $result;
        }
    }
    
        /**
    * メールアドレスがMysqlに登録されているかを確認
    * @access public
    * @return boolean
    **/
    public function insertUserinfo($email, $password, $companyId, $first_name, $last_name)
    {
        try {
                    $result = false;
                    $qy = "INSERT INTO pclog.user (mail_address, password,company_id,first_name,last_name) VALUES ('${email}','${password}','${companyId}','${first_name}','${last_name}');";
                    parent::setInfoLog("commit Sql : $qy");
                    $result=parent::commitStmt($qy);
        } catch (Exception $e) {
            echo $e;
            die($e);
        } finally {
            return $result;
        }
    }
}
