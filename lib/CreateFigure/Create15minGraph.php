<?php

include_once dirname(__FILE__)."/../Dao/TmpLogDao.php" ; 
include_once dirname(__FILE__)."/CreateGraph.php";

class Create15minGraph extends CreateGraph{
    private $Ymd;
    private $user;
    private $company;
    private $interval;

    private function setVal($val){
        $this->Ymd      = $val['date'];
        $this->company  = $val['company'];
        $this->user     = $val['user'];
        $this->interval = "15m";
    }
    
    function create($val){
        $this->setVal($val);
        return parent::create($this->Ymd, $this->company, $this->user, $this->interval);
    }
}
