<?php

class FormPost
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
        $result = $this->userDao->getUserName();
        $option="";
        foreach ($result as $row) {
            $option.="<option>".$row['user_name']."</option>";
        }
        return $option;
    }
    
    public function getCompanyOption()
    {
        $result = $this->companyDao->getCompanyName();
        $option="";
        foreach ($result as $row) {
            $option.="<option>".$row['company_name']."</option>";
        }
        return $option;
    }
}
