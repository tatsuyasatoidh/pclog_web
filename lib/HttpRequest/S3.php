<?php

//sdkパッケージを読み込み
require_once $_SERVER ['DOCUMENT_ROOT'].'/vendor/aws.phar';
class S3Request{

    private $bucket_name;
    
    public function __construct(){
        $this->bucket_name = 'elasticbeanstalk-us-west-2-443316351375';
    }
    
    
    public function putFile($bucket_name, $key_name){ 
        // Upload 
        $result = $this->s3Client->putObject([
            'Bucket' => $bucket_name,
            'Key'    => $key_name,
            'Body'   => 'this is the body!'
        ]);
    }
    
    
    /*
     * s3からファイルをダウンロードして、/tmpディレクトリに吐き出す。
     * @return string 出力したファイルパス 
     */
    public function getFile($key_name){
        //sdk設定   
        $sdk = new Aws\Sdk([
            'region'   => 'us-west-2',
            'version'  => '2006-03-01',
            'credentials' => array(
            'key' => 'AKIAJMFK3V5OXYQET64A',
            'secret'  => '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',
            )
        ]);
        
        // SDK内のＳ３クラスを使用
        $s3Client = $sdk->createS3();
        // Download
        $result = $s3Client->getObject([
            'Bucket' => $this->bucket_name,
            'Key'    => $key_name
        ]);
        
        /*s3からもってきたファイルをサーバーに出力する*/
        $key_name = str_replace('/','_',$key_name);
        $filename =  $_SERVER ['DOCUMENT_ROOT'].'/tmp/file/'.$key_name.".csv";
        $filename = str_replace('.csv.csv','.csv',$filename);

        if(!file_exists($_SERVER ['DOCUMENT_ROOT'].'/tmp')){
            mkdir($_SERVER ['DOCUMENT_ROOT'].'/tmp', 0755, true);
        }
        if(!file_exists($_SERVER ['DOCUMENT_ROOT'].'/tmp/file/')){
            mkdir($_SERVER ['DOCUMENT_ROOT'].'/tmp/file/', 0755, true);
        }
        if(!file_exists($filename)){
            touch($filename);
        }
        
        // ファイルに書き込む
        file_put_contents($filename, $result['Body']);

        // ファイルを出力する
        //readfile($filename);
        #ファイルパスを返す
        return $filename;
    }
}
?>
	