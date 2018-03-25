<?php
/*
*/ 
class Cli 
{
	/*
	*/   
    private $db;
	private $srv;
	/*
	*/	
    public function __construct() {

		$this->db = new PDO('mysql:host=54.38.187.177;dbname=jwt',"root","");		
	}
	/*
	*/
    public function setCliente($n, $d, $u, $i) {
    
		 if (strlen($i)){
			$sql = "UPDATE clientes SET nombre='".$n."', dni='$d' WHERE id = $i";
		 }else{
			$sql = "INSERT INTO clientes(nombre, dni,userid) VALUES ('" . $n . "', '" . $d . "',$u)";
		 }
		$result = $this->db->query($sql);
		if ($result) {
			return true;
		} else {
			return false;
		}
    }
	/*
	*/	
	public function getClientes($u) {
		$sql = "SELECT id, nombre, dni FROM clientes WHERE userid =".$u. " ORDER BY id DESC";
		foreach ($this->db->query($sql) as $res) {
			$this->srv[] = $res;
		}
		return $this->srv;	
    }
	/*
	*/	
	public function getClienteById($i){
		$sql = "SELECT id, nombre, dni, userid FROM clientes WHERE id =".$i;
		foreach ($this->db->query($sql) as $res) {
			$this->srv[] = $res;
		}
		return $this->srv;	
	}
	/*
	*/	
	public function delClienteById($i){
		$sql = "DELETE FROM clientes WHERE id =".$i;
		$result = $this->db->query($sql);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
}
?>