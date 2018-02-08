<?php
namespace Controller;

class_exists("Sys\Logging") 
    or require_once $_SERVER['DOCUMENT_ROOT']."/lib/Sys/Logging.php";
class_exists('Dao\UserDao') 
    or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/UserDao.php';
class_exists('Service\MailManage') 
    or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Service/MailManage.php';

use Sys\Logging as Logging;
use Dao\UserDao as UserDao;
use Service\MailManage as MailManage;

class MailRegistrationController
{
    /**
     * 
     * ログクラスインスタンス
     */
    private $logging;
    
    /**
     * 
     * エラーメッセージ
     */
    private $errorMessage = [];
    
    public function __construct()
    {
        $this->logging = new Logging();
        $this->userDao = new UserDao();
        $this->mailManage = new MailManage();
    }
    
    /**
     * Emailアドレスを登録して、仮パスワードを発行する処理
     *
     * @access public
     * @param  string $emailAdress
     */
    public function temporarilyRegister($emailAdress)
    {
        $this->logging->info("temporarilyRegister START");
        $provisionalPassWord = $this->issueProvisionalPassWord();
        $this->userDao->insertAdressAndPass($emailAdress, $provisionalPassWord);
        $this->mailManage->sendMail();
        $this->logging->info("temporarilyRegister END");
    }
    
    /**
     * Emailアドレスを登録して、仮パスワードを発行する処理
     *
     * @access public
     * @param  string $emailAdress
     */
    public function EmailIsNotExist($emailAdress)
    {
        $this->logging->info("EmailIsNotExist START");
        $checkEmailIsExist = $this->userDao->getByEmailAddress($emailAdress);
        var_dump($checkEmailIsExist);
        if($checkEmailIsExist == false) {
            //レコードが存在しないとき
            $result = true;
        }else{
            //レコードが存在するとき
            $this->errorMessage['EmailIsNotExist'] = "このメールアドレスはすでに利用されています";
            $result = false;
        }
        $this->logging->info("EmailIsNotExist END");
        return $result;
    }
    
    /**
     * 仮パスワードを発行する処理
     *
     * @access private
     * @return 12桁のランダムのパスワード
     */
    private function issueProvisionalPassWord()
    {
        try{
            $this->logging->info("issueProvisionalPassWord START");
            $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
            $provisionalPassWord = null;
            for ($i = 0; $i < 12; $i++) {
                $provisionalPassWord .= $str[rand(0, count($str) - 1)];
            }
        }catch(\Exception $e){
            
        }finally{
            $this->logging->info("provisionalPassWord : $provisionalPassWord");
            $this->logging->info("issueProvisionalPassWord END");
            return $provisionalPassWord;
        }
    }
    
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
