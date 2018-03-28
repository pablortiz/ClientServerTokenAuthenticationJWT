<?php
require_once("auth2.php");
$t = isset($_REQUEST["t"]) ? $_REQUEST["t"]  : "" ;
$ret = json_decode ( Auth2::check($t) );
$r = $ret->{'ret'};
if (!$r) {echo "Access denied"; exit;}
/*
*/
require_once 'vendor/autoload.php';
require_once 'auth.php';
if(!isset($_GET['p'])) die('No ha definido la página a visualizar');
$page = strtolower($_GET['p']);
$t = isset($_GET['t']) ?  $_GET['t']:"";
require_once "$page.php";
?>