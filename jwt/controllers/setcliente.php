<?php
require_once("auth2.php");
$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : "" ;
$ret = json_decode ( Auth2::check($t) );
$r = $ret->{'ret'};
if (!$r) {echo "Access denied"; exit;}
//echo "<pre>";print_r($ret);
require_once("../app/models/mysql_clientes.php");
$cli = new Cli();
$n  =   isset($_REQUEST["n"])?$_REQUEST["n"]:"";
$d  =   isset($_REQUEST["d"])?$_REQUEST["d"]:"";
$i  =   isset($_REQUEST["i"])?$_REQUEST["i"]:"";
$u= $ret->{'userid'};
$r  = $cli->setCliente($n,$d, $u,$i);	
echo $r;
