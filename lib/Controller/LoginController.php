<?php
namespace lib\Controller;

class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';
class_exists('lib\Dao\UserDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/UserDao.php';

use lib\Controller\ParentController as ParentController;
use lib\Dao\UserDao as UserDao;

class LoginController extends ParentController
{
    private $email;
    private $password;
    private $errorMessage = [];
    
    /**
     * コンストラクタ
     **/
    public function __construct($post = null)
    {
        foreach ($post as $key => $value) {
            $this->$key = $value;
        }
    }
    
    /**
     * emailの値がmysqlにあるかを確認
     **/
    public function getUserId()
    {
        $userDao = new UserDao();
        $userId = $userDao->getIdByEmailAndPassword($this->email, $this->password);
        if ($userId) {
            return $userId;
        } else {
            $this->errorMessage['checkEmailAndPassword'] = "メールアドレスまたはパスワードが間違っております。";
            return false;
        }
    }
    
    /**
     * $this->errorMessageのgetter
     * @access public
     **/
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
