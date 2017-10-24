<?php
namespace lib\Entity;

class Pclog {
    private $id;
    private $dt;
    private $userId;
    private $numberOfWork;
    
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function setDt($dt) {
        $this->dt = $dt;
    }
    public function getDt() {
        return $this->dt;
    }
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function getUserId() {
        return $this->userId;
    }	
    public function setNumberOfWork($numberOfWork) {
        $this->numberOfWork = $numberOfWork;
    }
    public function getNumberOfWork() {
        return $this->numberOfWork;
    }
    public function toArray() {
        return array (
            "id" => $this->id,
            "date" => $this->dt,
            "user_id" => $this->userId 
        );
    }
}
?>
