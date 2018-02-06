<?php
namespace lib\Controller;

ini_set('display_errors', 1);
class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';
class_exists('lib\Dao\UserDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/UserDao.php';

use lib\Controller\ParentController as ParentController;
use lib\Dao\UserDao as UserDao;

class SignInController extends ParentController
{
    private $errorMessage = [];
    /** ユーザー登録に成功したか*/
    private $signInFlag = false;
    
    private $lastname;
    private $firstname;
    private $emailaddress;
    private $password;
    private $passwordConfirmation;
    private $companyName;
    private $companyId;
    
    /**
     * コンストラクタ
     **/
    public function __construct($post = null)
    {
        foreach ($post as $key => $value) {
            $this->$key = $value;
        }
        if ($post != null) {
            /** パスワード確認*/
            $reslut = $this->checkPassWord($this->password, $this->passwordConfirmation);
            if ($reslut) {
                /** メールアドレスの確認　すでにある場合はfalseが帰ってくる*/
                $reslut = $this->checkMailAddress($this->emailaddress);
            }
            /** メールアドレスが登録されていないとき*/
            if (!$reslut) {
                /** ユーザー情報の登録*/
                $reslut = $this->insertUserinfo($this->emailaddress, $this->password, $this->companyId, $this->firstname, $this->lastname);
                if ($reslut) {
                    /** ユーザー情報のseikou */
                    $this->signInFlag = true;
                    header('Location:SignInComplete.php');
                    exit;
                }
            }
        }
    }
    
    /**
     * パスワードの確認
     * @access private
     **/
    private function checkPassWord($password, $passwordConfirmation)
    {
        parent::setInfoLog("checkPassWord START");
        $result = true;
        if ($password != $passwordConfirmation) {
            $result = false;
            $this->errorMessage["checkPassWord"] = "パスワード/パスワード確認の値が等しくありません。";
        }
        parent::setInfoLog("checkPassWord END");
        return $result;
    }
    
    /**
     * メールアドレスの確認
     * メールアドレスがすでにデータベースに登録されている場合は登録できない
     * @access private
     **/
    private function checkMailAddress($mailAddress)
    {
        parent::setInfoLog("checkMailAddress START");
        $userDao = new UserDao();
        /** すでに登録されている場合はtrueが帰ってくる*/
        $result = $userDao->checkEmail($mailAddress);
        
        if ($result) {
            $result = true;
            $this->errorMessage["checkMailAddress"] = "入力されたメールアドレスはすでに登録されています。";
        } else {
            $result = false;
        }
        var_dump($result);
        parent::setInfoLog("checkMailAddress END");
        return $result;
    }
    
    /**
     * ユーザー情報の登録
     * @access private
     **/
    private function insertUserinfo($email, $password, $companyId, $first_name, $last_name)
    {
        try {
            parent::setInfoLog("insertUserinfo START");
            $userDao = new UserDao();
            $result = $userDao->insertUserinfo($this->emailaddress, $this->password, $this->companyId, $this->firstname, $this->lastname);
        } catch (exception $e) {
            $this->errorMessage["insertUserinfo"] = "登録に失敗しました。";
        }
        parent::setInfoLog("insertUserinfo END");
        return $result;
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
    
    public function getPostValue()
    {
        return get_object_vars($this);
    }
    
    public function getSignInFlag()
    {
        return $this->signInFlag;
    }
}
