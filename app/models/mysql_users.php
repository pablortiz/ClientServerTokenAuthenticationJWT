<?php
/*
*/ 
class Users 
{
	/*
	*/    
    private $srv;
    private $db;
	/*
	*/ 
    public function __construct() {
		
		$this->db = new PDO('mysql:host=localhost;dbname=jwt',"root","");		
	}
	/*
	*/
    public function getUser($u) {
		$sql = "SELECT id FROM users where name='".$u."'";
		foreach ($this->db->query($sql) as $res) {
			$this->srv[] = $res;
		}
		return $this->srv;		
    }
	/*
	*/
	public function getKeyUser($id) {
		$sql = "SELECT pass FROM users where id=".$id;
		foreach ($this->db->query($sql) as $res) {
			$this->srv[] = $res;
		}
		return $this->srv;	
    }
	/*
	*/
    public function getUser2($u,$p) {
		$sql = "SELECT id FROM users where name='".$u."' and pass='".$p."'";
		foreach ($this->db->query($sql) as $res) {
			$this->srv[] = $res;
		}
		return $this->srv;	
    }
	/*
	*/
    public function setUser($u, $p) {
        $sql = "INSERT INTO users(name, pass) VALUES ('" . $u . "', '" . $p . "')";
        $result = $this->db->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
	/*
	*/
    public function setLogin($u, $token,$ip) {
		
		$t=explode(".",$token);
		if(count($t)==3)
		{
			$sql = "INSERT INTO userslogin(user, date, header, payload, signature,ip) VALUES ('" . $u . "', NOW(),'".$t[0]."','".$t[1]."','".$t[2]."','".$ip."')";
			$result = $this->db->query($sql);
			if ($result) {
				return true;
			} 
		}
		return false;
    }
}
?>