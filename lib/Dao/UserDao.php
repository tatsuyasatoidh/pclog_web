<?php
namespace lib\Dao;

class_exists('lib\Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';

use lib\Dao\ParentDao as ParentDao;

class UserDao extends ParentDao{

		public function get()
		{
			try {
				$qy = " SELECT * FROM pclog.user ";
				$result=parent::commitStmt($qy);
			} catch ( Exception $e ) {
				echo $e;
				die ( $e );
			} finally {
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
		} catch ( Exception $e ) {
			echo $e;
			die ( $e );
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
	public function getIdByEmailAndPassword($email,$passWord)
  {
    try {
            $result = false;
            $qy = " SELECT id FROM pclog.user WHERE mail_address ='${email}' AND password ='${passWord}'";
            parent::setInfoLog("commit Sql : $qy");
            $row=parent::commitStmt($qy);
        
            foreach ($row as $value){
                $result = $value[0];
                parent::setInfoLog("Sql result : $result");
            }
        } catch ( Exception $e ) {
           echo $e;
           die ( $e );
        } finally {
			return $result;
        }
    }
}