<?php
ini_set( 'display_errors', 1 );
$autoloader = new autoloader();

class autoloader
{
    public function __construct()
    {
        $this->loadDaoFile();
        $this->loadControllerFile();
    include_once dirname(__FILE__).'/../Log4j/Logger.php';
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Common/SessionClass.php"; 
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/CreateFigure/CreateGraph.php";
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Controller/form/formController.php";
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Common/DBConn.php" ; 
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Common/AbstractDao.php" ; 

    }
    
    private function loadControllerFile()
    {
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Entity/User.php";
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/HttpRequest/S3.php";
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Controller/Download/Download.php";
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Controller/FileManage.php";
    }
    
    private function loadDaoFile()
    {
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Dao/TmpLogDao.php" ; 
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Dao/pclogDao.php" ;   
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Dao/UserDao.php" ;   
    include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Dao/CompanyDao.php" ;   
        
    }
}