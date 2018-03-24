<?php
require_once 'vendor/autoload.php';
require_once 'auth.php';
if(!isset($_GET['p'])) die('No ha definido la página a visualizar');
$page = strtolower($_GET['p']);
$t = isset($_GET['t']) ?  $_GET['t']:"";
define('APPPATH','');
require_once "$page.php";
?>