<?php
error_reporting(E_ALL ^ E_NOTICE);
define('EmpireCMSAdmin','1');
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews=='login')
{
	define('EmpireCMSAPage','login');
}
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
if($enews=="login")
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
if($enews=="login")//登陆
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$key=$_POST['key'];
	$loginin=$username;
	login($username,$password,$key,$_POST);
}
elseif($enews=="exit")//退出系统
{
	loginout($logininid,$loginin,$loginrnd);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>