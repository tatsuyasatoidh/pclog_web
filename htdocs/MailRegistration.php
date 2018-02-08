<?php 
ini_set('display_errors', 1);
class_exists("Controller\MailRegistrationController") 
    or require_once $_SERVER['DOCUMENT_ROOT']."/lib/Controller/MailRegistrationController.php";

use Controller\MailRegistrationController as MailRegistrationController;

$registrationController= new MailRegistrationController();

if(isset($_POST['registMailaddress']) && !empty($_POST['mail'])) {    
    //メールアドレスがすでに登録されていないかを確認
    if($registrationController->EmailIsNotExist($_POST['mail'])) {
        //登録されていない場合は新しくパスワードを発行する
        $registrationController->temporarilyRegister($_POST['mail']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレス登録画面</title>
</head>
<body>
    <div id="container">
        <h1 class="pageHeader">
        メールアドレス登録画面
        </h1>
        <form class="col-lg-12" method="post" id="mailRegistrationForm">
            <?php foreach ($registrationController->getErrorMessage() as $message):?>
            <div class="errorMessage"><?php echo $message;?></div>
            <?php endforeach;?>
            <input type="email" name="mail">
            <input type="submit" name="registMailaddress" value="仮パスワードを発行">
        </form>
    </div>
</body>
</html>