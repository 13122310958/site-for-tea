<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/delpath.php");
require("../class/copypath.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
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
$incftp=0;
if($public_r['phpmode'])
{
	include("../class/ftp.php");
	$incftp=1;
}
//防采集
if($public_r['opennotcj'])
{
	@include("../data/dbcache/notcj.php");
}
require("../class/classfun.php");
if($enews=="AddZt")//增加专题
{
	AddZt($_POST,$logininid,$loginin);
}
elseif($enews=="EditZt")//修改专题
{
	EditZt($_POST,$logininid,$loginin);
}
elseif($enews=="DelZt")//删除专题
{
	$ztid=$_GET['ztid'];
	DelZt($ztid,$logininid,$loginin);
}
elseif($enews=="AddClass")//增加栏目
{
	AddClass($_POST,$logininid,$loginin);
}
elseif($enews=="EditClass")//修改栏目
{
	EditClass($_POST,$logininid,$loginin);
}
elseif($enews=="DelClass")//删除栏目
{
	$classid=$_GET['classid'];
	DelClass($classid,$logininid,$loginin);
}
elseif($enews=="ChangeClassIslast")//终极栏目属性转换
{
	ChangeClassIslast($_POST['reclassid'],$logininid,$loginin);
}
elseif($enews=="EditClassOrder")//修改栏目顺序
{
	$classid=$_POST['classid'];
	$myorder=$_POST['myorder'];
	EditClassOrder($classid,$myorder,$logininid,$loginin);
}
elseif($enews=="ChangeSonclass")//更新栏目关系
{
	$start=$_GET['start'];
	ChangeSonclass($start,$logininid,$loginin);
}
elseif($enews=="DelFcListClass")//删除栏目缓存文件
{
	DelFcListClass();
}
elseif($enews=="SetMoreClass")//批量设置栏目
{
	SetMoreClass($_POST,$logininid,$loginin);
}
elseif($enews=='AddClassF')//增加栏目字段
{
	AddClassF($_POST,$logininid,$loginin);
}
elseif($enews=='EditClassF')//修改栏目字段
{
	EditClassF($_POST,$logininid,$loginin);
}
elseif($enews=='DelClassF')//删除栏目字段
{
	DelClassF($_GET,$logininid,$loginin);
}
elseif($enews=='EditClassFOrder')//修改栏目字段顺序
{
	EditClassFOrder($_POST['fid'],$_POST['myorder'],$logininid,$loginin);
}
elseif($enews=='AddZtF')//增加专题字段
{
	AddZtF($_POST,$logininid,$loginin);
}
elseif($enews=='EditZtF')//修改专题字段
{
	EditZtF($_POST,$logininid,$loginin);
}
elseif($enews=='DelZtF')//删除专题字段
{
	DelZtF($_GET,$logininid,$loginin);
}
elseif($enews=='EditZtFOrder')//修改专题字段顺序
{
	EditZtFOrder($_POST['fid'],$_POST['myorder'],$logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>