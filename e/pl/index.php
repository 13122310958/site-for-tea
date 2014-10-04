<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../data/dbcache/class.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
eCheckCloseMods('pl');//关闭模块
//用户名
$lusername=getcvar('mlusername');
$lpassword='';
if($lusername)
{
	$lusername=RepPostVar($lusername);
	$lpassword=md5($lusername);
}
$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
//专题
$doaction=$_GET['doaction']=='dozt'?'dozt':'';
if($doaction=='dozt')
{
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)",1);
	}
	$n_r=$empire->fetch1("select ztid,ztname,intro,ztimg,ztpagekey,restb from {$dbtbpre}enewszt where ztid='$classid'");
	if(!$n_r['ztid'])
	{
		printerror("ErrorUrl","history.go(-1)",1);
	}
	$pubid='-'.$classid;
	$search="&doaction=dozt&classid=$classid";
	//标题链接
	$titleurl=sys_ReturnBqZtname($n_r);
	$title=stripSlashes($n_r['ztname']);
	$pagetitle=ehtmlspecialchars($title);
	//评分
	$infopfennum=0;
	$pinfopfen=0;
	$url=ReturnZtLink($n_r['ztid'])."&nbsp;>&nbsp;".$fun_r[pl];
}
else
{
	if(empty($id)||empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)",1);
	}
	if(empty($class_r[$classid][tbname])||InfoIsInTable($class_r[$classid][tbname]))
	{
		printerror("ErrorUrl","history.go(-1)",1);
	}
	$n_r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
	if(!$n_r['id']||$n_r['classid']!=$classid)
	{
		printerror("ErrorUrl","history.go(-1)",1);
	}
	$pubid=ReturnInfoPubid($classid,$id);
	$search="&classid=$classid&id=".$id;
	//标题链接
	$titleurl=sys_ReturnBqTitleLink($n_r);
	$title=stripSlashes($n_r[title]);
	$pagetitle=ehtmlspecialchars($title);
	//评分
	$infopfennum=$n_r['infopfennum'];
	$pinfopfen=$infopfennum?round($n_r['infopfen']/$infopfennum):0;
	$url=ReturnClassLink($n_r[classid])."&nbsp;>&nbsp;<a href=".$titleurl.">".$title."</a>&nbsp;>&nbsp;".$fun_r[pl];
}
//使用模板
if($_GET['tempid'])
{
	$tempid=(int)$_GET['tempid'];
	$tempnum=$empire->gettotal("select count(*) as total from ".GetTemptb("enewspltemp")." where tempid='$tempid'");
	$tempid=$tempnum?$tempid:$public_r['defpltempid'];
	$search.='&tempid='.$tempid;
}
else
{
	if($doaction=='dozt')
	{
		$tempid=$class_zr[$classid]['pltempid']?$class_zr[$classid]['pltempid']:$public_r['defpltempid'];
	}
	else
	{
		$tempid=$class_r[$classid]['pltempid']?$class_r[$classid]['pltempid']:$public_r['defpltempid'];
	}
}
if(empty($tempid))
{
	$tempid=1;
}
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$page_line=12;//每页显示链接数
$line=$public_r['pl_num'];//每页显示记录数
$offset=$page*$line;//总偏移量
$query="select * from {$dbtbpre}enewspl_".$n_r['restb']." where pubid='$pubid' and checked=0";
//总数量
if($doaction=='dozt')
{
	$totalquery="select count(*) as total from {$dbtbpre}enewspl_".$n_r['restb']." where pubid='$pubid' and checked=0";
	$num=$empire->gettotal($totalquery);
}
else
{
	//需审核
	if($class_r[$classid][checkpl])
	{
		$totalquery="select count(*) as total from {$dbtbpre}enewspl_".$n_r['restb']." where pubid='$pubid' and checked=0";
		$num=$empire->gettotal($totalquery);
	}
	else
	{
		$num=$n_r['plnum'];
	}
}
//排序
$addorder='plid desc';
$myorder=(int)$_GET['myorder'];
if($myorder==1)
{
	$addorder='plid';
	$search.='&myorder='.$myorder;
}
$query.=" order by ".$addorder." limit $offset,$line";
$sql=$empire->query($query);
$listpage=page1($num,$line,$page_line,$start,$page,$search);
@require(ECMS_PATH.'e/data/filecache/template/pl'.$tempid.'.php');
db_close();
$empire=null;
?>