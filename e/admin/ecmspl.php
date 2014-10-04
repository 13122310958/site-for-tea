<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../data/dbcache/class.php");
$link=db_connect();
$empire=new mysqlquery();
$enews=$_POST['enews'];
if(empty($enews))
{
	$enews=$_GET['enews'];
}
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
require("../class/hplfun.php");
if($enews=="DelPl_all")//删除评论
{
	$plid=$_POST['plid'];
	$id=$_POST['id'];
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	DelPl_all($plid,$id,$bclassid,$classid,$logininid,$loginin);
}
elseif($enews=="CheckPl_all")//审核评论
{
	$plid=$_POST['plid'];
	$id=$_POST['id'];
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	CheckPl_all($plid,$id,$bclassid,$classid,$logininid,$loginin);
}
elseif($enews=='DoGoodPl_all')//推荐评论
{
	$plid=$_POST['plid'];
	$id=$_POST['id'];
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	$isgood=$_POST['isgood'];
	DoGoodPl_all($plid,$id,$bclassid,$classid,$isgood,$logininid,$loginin);
}
elseif($enews=='AddPlF')//增加评论字段
{
	AddPlF($_POST,$logininid,$loginin);
}
elseif($enews=='EditPlF')//修改评论字段
{
	EditPlF($_POST,$logininid,$loginin);
}
elseif($enews=='DelPlF')//删除评论字段
{
	DelPlF($_GET,$logininid,$loginin);
}
elseif($enews=='AddPlDataTable')//增加评论分表
{
	AddPlDataTable($_POST,$logininid,$loginin);
}
elseif($enews=='DefPlDataTable')//默认评论分表
{
	DefPlDataTable($_GET,$logininid,$loginin);
}
elseif($enews=='DelPlDataTable')//删除评论分表
{
	DelPlDataTable($_GET,$logininid,$loginin);
}
elseif($enews=='SetPl')//评论参数设置
{
	SetPl($_POST,$logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>