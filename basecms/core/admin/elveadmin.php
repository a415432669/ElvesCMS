<?php
error_reporting(E_ALL ^ E_NOTICE);
define('ElvesCMSAdmin','1');
$melve=$_POST['melve'];
if(empty($melve))
{$melve=$_GET['melve'];}
if($melve=='login')
{
	define('ElvesCMSAPage','login');
}
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$Elves=new mysqlquery();
if($melve=="login")
{}
else
{
	//验证用户
	$lur=is_login();
	$logininid=$lur['userid'];
	$loginin=$lur['username'];
	$loginrnd=$lur['rnd'];
	$loginlevel=$lur['groupid'];
	$loginadminstyleid=$lur['adminstyleid'];
}
require("../class/adminfun.php");
if($melve=="login")//登陆
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$key=$_POST['key'];
	$loginin=$username;
	login($username,$password,$key,$_POST);
}
elseif($melve=="exit")//退出系统
{
	loginout($logininid,$loginin,$loginrnd);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$Elves=null;
?>