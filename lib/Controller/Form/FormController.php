<?php
namespace lib\Controller;

class_exists('lib\Dao\UserDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/UserDao.php';
class_exists('lib\Dao\CompanyDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/CompanyDao.php';
class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';

use lib\Dao\UserDao as UserDao;
use lib\Dao\CompanyDao as CompanyDao;
use lib\Controller\ParentController as ParentController;

class FormController extends ParentController
{
    private $userDao;
    private $companyDao;
    
    public function __construct()
    {
        $this->userDao = new UserDao();
        $this->companyDao = new CompanyDao();
    }
    
    public function getUserOption()
    {
                parent::setInfoLog("getUserOption START");
        $result = $this->userDao->get();
        $option="";
        foreach ($result as $row) {
            $option.="<option value=".$row['id'].">".$row['user_name']."</option>";
        }
                parent::setInfoLog("getUserOption END");
        return $option;
    }
    
    public function getCompanyOption()
    {
        $result = $this->companyDao->get();
        $option="";
        foreach ($result as $row) {
            $option.="<option value=".$row['id'].">".$row['company_name']."</option>";
        }
        return $option;
    }
}
