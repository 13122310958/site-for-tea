<?php
require("../../class/connect.php");
require("../../class/q_functions.php");
require("../../class/db_sql.php");
require("../../data/dbcache/class.php");
require("../../member/class/user.php");
require('../class/ShopSysFun.php');
eCheckCloseMods('shop');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$shoppr=ShopSys_ReturnSet();
//验证权限
ShopCheckAddDdGroup($shoppr);
$addressid=(int)$_GET['addressid'];
//用户信息
$user=array();
$useraddr=array();
$user[userid]=0;
$email='';
if(getcvar('mluserid'))
{
	$user=islogin();
	//地址
	$addressr=ShopSys_GetAddress($addressid);
	if($addressr['addressid'])
	{
		$email=$addressr['email'];
		$useraddr=$addressr;
	}
	else
	{
		$email=GetUserEmail($user[userid],$user[username]);
		$useraddr=$empire->fetch1("select truename,oicq,msn,`mycall`,phone,address,zip from {$dbtbpre}enewsmemberadd where userid='$user[userid]' limit 1");
	}
}
//导入模板
require(ECMS_PATH.'e/template/ShopSys/order.php');
db_close();
$empire=null;
?>