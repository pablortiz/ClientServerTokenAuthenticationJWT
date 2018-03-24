<?php
require_once("../jwt/auth2.php");
$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : "" ;
$i = isset($_REQUEST["i"]) ? $_REQUEST["i"] : "" ;
$ret = json_decode ( Auth2::check($t) );
$r = $ret->{'ret'};
$u= $ret->{'userid'};
if (!$r) {echo "Access denied"; exit;}
require_once("../app/models/mysql_clientes.php");
$cli = new Cli();
$datos  = $cli->delClienteById($i);	
echo $datos;
