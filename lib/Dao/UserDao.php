<?php
namespace Dao;

class_exists('Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';

use lib\Dao\ParentDao as ParentDao;

class UserDao extends ParentDao
{
    const TABLE_NAME = "user";

    const COLUMN_MAIL_ADDRESS = "mail_address";
    const COLUMN_PASSWORD = "password";
 
    /**
     * 
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * アドレスとパスワードを追加する関数
     *
     * @access public
     * @param  string $address
     * @param  string $pass
     * @return boolean
     **/
    public function insertAdressAndPass($address,$pass)
    {
        try{
            $_ = function ($s) {
                return "$s";
            };//展開用
            
            $this->logging->info("insertAdressAndPass START");
            $this->logging->info("address : $address");
            $this->logging->info("pass : $pass");
            $sql = "INSERT INTO {$_(self::TABLE_NAME)} 
                    ({$_(self::COLUMN_MAIL_ADDRESS)},{$_(self::COLUMN_PASSWORD)})
                    VALUES('$address','$pass')";
            $this->logging->info("sql : $sql");
            $this->commitStmt($sql);
        }catch(\Exception $e){
            
        }finally{
            $this->logging->info("insertAdressAndPass END");
        }  
    }
  
    /**
     * アドレスを使ってレコードを取得する関数
     *
     * @access public
     * @param  string $address
     * @param  string $pass
     * @return row or 0
     **/
    public function getByEmailAddress($address)
    {
        try{
            $_ = function ($s) {
                return "$s";
            };//展開用
            $this->logging->info("insertAdressAndPass START");
            $this->logging->info("address : $address");
            $sql = "SELECT * FROM {$_(self::TABLE_NAME)} WHERE {$_(self::COLUMN_MAIL_ADDRESS)} = '$address'";
            $this->logging->info("sql : $sql");
            $sqlResult = $this->commitStmt($sql);
            $sqlResult = $sqlResult->fetchAll();
            if(count($sqlResult) == 0) {
                $result = false;
            }else{
                $result = $sqlResult;
            }
        }catch(\Exception $e){
            
        }finally{
            $this->logging->info("insertAdressAndPass END");
            return $result;
        }  
    }
}
