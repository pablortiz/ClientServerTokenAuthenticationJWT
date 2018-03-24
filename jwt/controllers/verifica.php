<?php
if(!isset($_GET['t'])) die('Debe especificar el token');
require_once("../../app/models/mysql_users.php");
$users = new Users();
$token = $_GET['t'];
$secret_key = 'Sdw1s9x8@';
$jwt_values = explode('.', $token);
$ret = json_decode ( base64_decode($jwt_values[1]) );
$r = $users->getKeyUser($ret->{'data'}->{'id'});
$secret_key = $r[0]["pass"];
$jwt_values[2] = $jwt_values[2] ;
$recieved_signature = $jwt_values[2];
$recievedHeaderAndPayload = $jwt_values[0] . '.' . $jwt_values[1];
$resultedsignature = base64_encode(hash_hmac('sha256', $recievedHeaderAndPayload, $secret_key, true));
$resultedsignature =  str_replace("+","-",$resultedsignature);
$resultedsignature =  str_replace("=","",$resultedsignature);
$resultedsignature =  str_replace("/","_",$resultedsignature);
if($resultedsignature == $recieved_signature) {
	echo '{"ret": "1", "message": "token successful ","username": "'.$ret->{'data'}->{'username'}.'","userid":"'.$ret->{'data'}->{'id'}.'","time":"'.$ret->{'exp'}.'"}';
}else{	
	echo '{"ret": "0","message": "Token no authenticated!", "token": ""}';
}
?>