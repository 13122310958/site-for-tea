<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../data/dbcache/class.php");
require("../member/class/user.php");
require("../class/q_functions.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
//验证是否登陆
$user=islogin();
//取得模型id
$mid=(int)$_GET['mid'];
if(!$mid)
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$mr=$empire->fetch1("select tbname,qmname,listfile,sonclass from {$dbtbpre}enewsmod where mid='$mid'");
if(!$mr['tbname']||InfoIsInTable($mr['tbname']))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
esetcookie("qdelinfo","dgcms");
$totalnum=(int)$_GET['totalnum'];
$start=0;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$line=25;//每行显示
$page_line=16;
$offset=$page*$line;
$add='';
$search="&mid=$mid";
//审核表
$ecmscheck=(int)$_GET['ecmscheck'];
$addecmscheck='';
$indexchecked=1;
if($ecmscheck)
{
	$search.='&ecmscheck='.$ecmscheck;
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}
$infotb=ReturnInfoMainTbname($mr['tbname'],$indexchecked);
//显示方式
if($public_r['qlistinfomod'])
{
	$modnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmod where tbname='$mr[tbname]'");
	if($modnum>1)
	{
		$add.=' and ('.ReturnClass($mr['sonclass']).')';
	}
}
//搜索
$sear=$_GET['sear'];
if($sear)
{
	$keyboard=RepPostVar2($_GET['keyboard']);
	$show=$_GET['show'];
	//关键字
	if($keyboard)
	{
		$add.=" and (title like '%$keyboard%')";
	}
	$search.="&sear=1&keyboard=$keyboard&show=$show";
}
//优化
$yhid=$etable_r[$mr[tbname]][yhid];
$yhvar='qmlist';
$yhadd='';
if($yhid)
{
	$yhadd=ReturnYhSql($yhid,$yhvar,1);
}
//信息表
$totalquery="select count(*) as total from ".$infotb." where ".$yhadd."userid='$user[userid]' and ismember=1".$add;
if($totalnum<1)
{
	$num=$empire->gettotal($totalquery);//取得总条数
}
else
{
	$num=$totalnum;
}
$search.="&totalnum=$num";
$returnpage=page1($num,$line,$page_line,$start,$page,$search);
//导入页面
$deftempfile=ECMS_PATH.'e/data/html/list/qlistinfo.php';
if($mr[listfile])
{
	$tempfile=ECMS_PATH.'e/data/html/list/q'.$mr[listfile].'.php';
	if(!file_exists($tempfile))
	{
		$tempfile=$deftempfile;
	}
}
else
{
	$tempfile=$deftempfile;
}
require($tempfile);
db_close();
$empire=null;
?>