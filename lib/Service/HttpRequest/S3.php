<?php
namespace lib\Service\HttpRequest;

//sdkパッケージを読み込み
require_once $_SERVER ['DOCUMENT_ROOT'].'/vendor/aws.phar';
class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';

use lib\Controller\ParentController as ParentController;

class S3Request extends ParentController
{
	const bucket_name = 'elasticbeanstalk-us-west-2-443316351375';
    
    public function __construct(){
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
		 * @param string $localPath ダウンロードをしたファイルを出力するパス
		 * @param string $key_name キー名
     * @return string 出力したファイルパス 
     */
    public function getFile($localPath,$key_name){
		
		parent::setInfoLog("getFile START");
		
        //sdk設定   
        $sdk = new \Aws\Sdk([
            'region'   => 'us-west-2',
            'version'  => 'latest',
            'credentials' => array(
            'key' => 'AKIAJMFK3V5OXYQET64A',
            'secret'  => '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',
            )
        ]);
        
        // SDK内のＳ３クラスを使用
        $s3Client = $sdk->createS3();
        // Download
        $result = $s3Client->getObject([
            'Bucket' => self::bucket_name,
            'Key'    => $key_name
        ]);
        
        /*s3からもってきたファイルをサーバーに出力する*/
        $key_name = str_replace('/','_',$key_name);
      
        if(!file_exists($localPath)){
            mkdir($localPath, 0755, true);
        }
        if(!file_exists($localPath)){
            touch($localPath);
        }
        $length = $result['ContentLength'];
        $result['Body']->rewind();
        $data = $result['Body']->read($length);
        // ファイルに書き込む
        file_put_contents($localPath, $data);
				parent::setInfoLog("getFile END");
        #ファイルパスを返す
        return $localPath;
    }
}
?>
	