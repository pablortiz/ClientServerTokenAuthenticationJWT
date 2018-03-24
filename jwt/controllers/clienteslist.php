<?php
require_once("../jwt/auth2.php");
$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : "" ;
$ret = json_decode ( Auth2::check($t) );
$r = $ret->{'ret'};
if (!$r) {echo "Access denied"; exit;}
require_once("../app/models/mysql_clientes.php");
$cli = new Cli();
$u= $ret->{'userid'};
$datos  = $cli->getClientes($u);	
require_once("../app/views/ClientesList.php");
