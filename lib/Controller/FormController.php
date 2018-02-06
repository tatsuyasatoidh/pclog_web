<?php
namespace lib\Controller;

class_exists('lib\Entity\User') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Entity/User.php';
class_exists('lib\Dao\UserDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/UserDao.php';
class_exists('lib\Dao\CompanyDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/CompanyDao.php';
class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';

use lib\Entity\User as User;
use lib\Dao\UserDao as UserDao;
use lib\Dao\CompanyDao as CompanyDao;
use lib\Controller\ParentController as ParentController;

class FormController extends ParentController
{
    private $userDao;
    private $companyDao;
    
    private $permition;
    
    public function __construct($userId = null)
    {
            /** ユーザーIDから企業IDを取得。IDH以外は自分の所属企業しか取得しない*/
        $this->loginUser = new User($userId);
        $this->userDao = new UserDao();
                $this->companyDao = new CompanyDao();
                $this->permition = $this->loginUser->getPermition();
    }
    
    public function displayUserOption()
    {
                parent::setInfoLog("getUserOption START");
        if ($this->permition =="ALL") {
             $result = $this->userDao->get();
        } else {
            /** 権限がない場合はログインの所属企業のみのユーザー名を返す*/
            $result = $this->userDao->getByCompanyId($this->loginUser->getCompanyId());
        }
        $option="";
        foreach ($result as $row) {
            $option.="<option value=".$row['id'].">".$row['user_name']."</option>";
        }
                parent::setInfoLog("getUserOption END");
        return $option;
    }
    
    public function displayCompanyOption()
    {
        if ($this->permition =="ALL") {
            $result = $this->companyDao->get();
            $option="";
            foreach ($result as $row) {
                $option.="<option value=".$row['id'].">".$row['company_name']."</option>";
            }
        } else {
                    $option=false;
        }
        return $option;
    }
    
    public function checkPage()
    {
        if ($_SERVER['REQUEST_URI'] == "/htdocs/DailyGraph.php") {
            $result = "PERSON";
        } else {
            $result = "LIST";
        }
        return $result;
    }
}
