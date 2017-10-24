<?php
namespace lib\Entity;

class_exists('lib\Dao\UserDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/UserDao.php';

use lib\Dao\UserDao as UserDao;

class User {
	
	private $id;
	private $userName;
	private $mailAddress;
	private $machineName;
	private $companyId;

	/** コンストラクタ*/
	public function __construct($userId = null)
	{
		if($userId !=null){
			$userDao = new UserDao();
			$userINfoArray = $userDao->getByUserId($userId);
			foreach ($userINfoArray as $value)
			{
				$this->id = $value['id'];
				$this->userName = $value['user_name'];
			}
		}
	}
    
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function setUserName($userName) {
        $this->userName = $userName;
    }
    public function getUserName() {
        return $this->userName;
    }	
    public function setMailAddress($mailAddress) {
        $this->mailAddress = $mailAddress;
    }
    public function getMailAddress() {
        return $this->mailAddress;
    }
    public function getMachineName() {
        return $this->machineName;
    }
    public function setMachineName($machineName) {
        $this->machineName = $machineName;
    }
    public function setCompanyId($companyId) {
        $this->companyId = $companyId;
    }
    public function getCompanyId() {
        return $this->companyId;
    }
}
?>
