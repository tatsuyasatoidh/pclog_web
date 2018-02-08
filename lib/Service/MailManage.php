<?php
namespace Service;

class_exists("Sys\Logging") 
    or require_once $_SERVER['DOCUMENT_ROOT']."/lib/Sys/Logging.php";

use Sys\Logging as Logging;

class MailManage
{
    public function __construct()
    {
        $this->logging = new Logging();
    }
    
    public function sendMail()
    {
        try{
            $this->logging->info("sendMail START");
            $to      = 'satou.tatsuya@idh-net.co.jp';
            $subject = '仮登録完了のお知らせ';
            $message = '仮登録完了のお知らせ　\r\n';
            $headers = 'From: satou.tatsuya@idh-net.co.jp' . "\r\n";
            $result = mail($to, $subject, $message, $headers);
            
            var_dump($result);
        }finally{
            $this->logging->info("sendMail END");
        }
        
    }
}
