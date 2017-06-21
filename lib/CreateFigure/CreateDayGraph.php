<?php
require_once ""
class CreateDayGraph extends CreateGraph
{
    
    /* 15分グラフ */
    public function fifteenthMin($val)
    {
        $this->setVal($val['date'], $val['company'], $val['user'],"15m");
        $result = $this->create();
        
        if(!$result){
            return $this->dataNotAvailable();
        }else{
            return $result;
        }
    }
    
    /* 30分グラフ */
    public function thirtiethMin($val)
    {
        $this->setVal($val['date'], $val['company'], $val['user'],"30m");
        $result = $this->create();
        if(!$result){
            return $this->dataNotAvailable();
        }else{
            return $result;
        }
    }
    
    /* 1時間グラフ */
    public function hourhMin($val)
    {
        $this->setVal($val['date'], $val['company'], $val['user'],"1h");
        $result = $this->create();
        if(!$result){
            return $this->dataNotAvailable();
        }else{
            return $result;
        }
    }
}