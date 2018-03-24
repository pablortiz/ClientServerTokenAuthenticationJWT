<?php
require_once '../vendor/autoload.php';
require_once '../auth.php';
require_once("../../app/models/mysql_users.php");
$users = new Users();
$u  =   isset($_REQUEST["u"])?$_REQUEST["u"]:"";
$p  =   isset($_REQUEST["p"])?$_REQUEST["p"]:"";
$r  = $users->getUser($u);	
if (count($r)){
	echo '{"ret": "0","message": "User already exists", "token": ""}';
}else{
	$users->setUser($u,$p);
	echo '{"ret": "1","message": "Registered user. You can login in de App.", "token": ""}';	
}
?>####  