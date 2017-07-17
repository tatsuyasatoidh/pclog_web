<?php

class FileManage
{
     /*
     * csvファイルを配列にする
     * @return  array 配列
     */
    public function csvToArray($csvFile){
        $filepath = str_replace('.csv.csv','.csv',$csvFile);
        $array  = array();
        $fp   = fopen($filepath, "r");
        while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
        $array[] = $data;
        }
        fclose($fp);
        return $array;
    }
    
}