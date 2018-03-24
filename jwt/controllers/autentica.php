<?php
require_once '../vendor/autoload.php';
require_once '../auth.php';
require_once("../../app/models/mysql_users.php");
$users = new Users();
//print_r($_REQUEST);
$u  =   isset($_REQUEST["u"])?$_REQUEST["u"]:"";
$p  =   isset($_REQUEST["p"])?$_REQUEST["p"]:"";
$id=0;
$r  = $users->getUser2($u,$p);
if(count($r))	
{	
	Auth::setKey ($p);
	echo '{"ret": "1", "message": "login successful!", "token": "';
	$token =  Auth::SignIn([
		'message' => 'login successful!',
        'id' => $r[0]["id"],  
		"username"=> $u
    ]);
	echo $token;
	echo '"}';
	$r  = $users->setLogin($r[0]["id"],$token,Aud());
}else{
	echo '{"ret": "0","message": "Incorrect user or password !", "token": ""}';	
}
function Aud()
{
	$aud = $_SERVER['REMOTE_ADDR'];
	$aud .= "___".@$_SERVER['HTTP_USER_AGENT'];
	$aud .= "___".gethostname();
	return $aud;
}
?>####