<?php session_start();

/** userIDセッションがない場合、ログイン画面にとばす*/
if(!$_SESSION["UserId"]){
	 header('Location: /htdocs/Login.php');
}
