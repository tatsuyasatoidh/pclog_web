<?php

class User {
    private $id;
    private $userName;
    private $mailAddress;
    private $machineName;
    private $companyId;
    
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
