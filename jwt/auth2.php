<?php
require_once("../app/models/mysql_users.php");
/*
*/
class Auth2
{
	/*
	*/
	public static function check($token)
	{
		$ret2 = '{"ret": "0","message": "Token no authenticated!", "token": ""}';	
		$users = new Users();
		$secret_key = '123456789@';
		$jwt_values = explode('.', $token);
		if(count($jwt_values)==3)
		{
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
				$ret2 =  '{"ret": "1", "message": "token successful ","username": "'.$ret->{'data'}->{'username'}.'","userid":"'.$ret->{'data'}->{'id'}.'","time":"'.$ret->{'exp'}.'"}';
			}	
		}
		return $ret2;
	}
}
?>