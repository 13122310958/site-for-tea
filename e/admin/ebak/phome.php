<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
require("class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$phome=$_GET['phome'];
if(empty($phome))
{
	$phome=$_POST['phome'];
}
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
if($phome=="SetDb")//参数设置
{
}
elseif($phome=="DoRep")//修复表
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_Rep($tablename,$mydbname,$logininid,$loginin);
}
//忧化表
elseif($phome=="DoOpi")
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_Opi($tablename,$mydbname,$logininid,$loginin);
}
//删除表
elseif($phome=="DoDrop")
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_Drop($tablename,$mydbname,$logininid,$loginin);
}
//删除数据库
elseif($phome=="DropDb")
{
	$mydbname=$_GET['mydbname'];
	Ebak_DropDb($mydbname,$logininid,$loginin);
}
//建立数据库
elseif($phome=="CreateDb")
{
	$mydbname=$_POST['mydbname'];
	$mydbchar=$_POST['mydbchar'];
	Ebak_CreatDb($mydbname,$mydbchar,$logininid,$loginin);
}
//清空表
elseif($phome=="EmptyTable")
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_EmptyTable($tablename,$mydbname,$logininid,$loginin);
}
//初使化备份表
elseif($phome=="DoEbak")
{
	Ebak_DoEbak($_POST,$logininid,$loginin);
}
//备份表(按文件)
elseif($phome=="BakExe")
{
	$t=$_GET['t'];
	$s=$_GET['s'];
	$p=$_GET['p'];
	$mypath=$_GET['mypath'];
	$alltotal=$_GET['alltotal'];
	$thenof=$_GET['thenof'];
	$fnum=$_GET['fnum'];
	$stime=$_GET['stime'];
	Ebak_BakExe($t,$s,$p,$mypath,$alltotal,$thenof,$fnum,$stime,$logininid,$loginin);
}
//备份表(按记录)
elseif($phome=="BakExeT")
{
	$t=$_GET['t'];
	$s=$_GET['s'];
	$p=$_GET['p'];
	$mypath=$_GET['mypath'];
	$alltotal=$_GET['alltotal'];
	$thenof=$_GET['thenof'];
	$fnum=$_GET['fnum'];
	$auf=$_GET['auf'];
	$aufval=$_GET['aufval'];
	$stime=$_GET['stime'];
	Ebak_BakExeT($t,$s,$p,$mypath,$alltotal,$thenof,$fnum,$auf,$aufval,$stime,$logininid,$loginin);
}
//恢复数据
elseif($phome=="ReData")
{
	$add=$_POST['add'];
	$mypath=$_POST['mypath'];
	Ebak_ReData($add,$mypath,$logininid,$loginin);
}
//删除备份目录
elseif($phome=="DelBakpath")
{
	$path=$_GET['path'];
	Ebak_DelBakpath($path,$logininid,$loginin);
}
//删除压缩包
elseif($phome=="DelZip")
{
	$f=$_GET['f'];
	Ebak_DelZip($f,$logininid,$loginin);
}
//压缩目录
elseif($phome=="DoZip")
{
	$p=$_GET['p'];
	Ebak_Dozip($p,$logininid,$loginin);
}
//目录转向
elseif($phome=="PathGotoRedata")
{
	$mypath=$_GET['mypath'];
	Ebak_PathGotoRedata($mypath,$logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
?>
