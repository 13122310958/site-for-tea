<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../data/dbcache/class.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
eCheckCloseMods('print');//关闭模块
$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
if(empty($id)||empty($classid))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$mid=$class_r[$classid]['modid'];
$tbname=$class_r[$classid][tbname];
if(empty($tbname)||InfoIsInTable($tbname))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1");
if(empty($r['id'])||$r['classid']!=$classid)
{
	printerror("ErrorUrl","history.go(-1)",1);
}
//副表
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
//权限
if($r['groupid']||$class_r[$classid]['cgtoinfo'])
{
	include('../data/dbcache/MemberLevel.php');
	define('empirecms','wm_chief');
	define('PageCheckLevel','wm_chief');
	$check_tbname=$tbname;
	$check_infoid=$id;
	$check_classid=$classid;
	$check_path="../../";
	$checkinfor=$r;
	include("../class/CheckLevel.php");
}
//使用模板
if($_GET['tempid'])
{
	$tempid=(int)$_GET['tempid'];
	$tempnum=$empire->gettotal("select count(*) as total from ".GetTemptb("enewsprinttemp")." where tempid='$tempid'");
	$tempid=$tempnum?$tempid:$public_r['defprinttempid'];
}
else
{
	$mod_tempr=$empire->fetch1("select printtempid from {$dbtbpre}enewsmod where mid='$mid'");
	$tempid=$mod_tempr[printtempid]?$mod_tempr[printtempid]:$public_r['defprinttempid'];
}
if(empty($tempid))
{
	$tempid=1;
}
//存文本
$savetxtf=$emod_r[$mid]['savetxtf'];
if($savetxtf&&$r[$savetxtf])
{
	$r[$savetxtf]=GetTxtFieldText($r[$savetxtf]);
}
//分页字段
$pagef=$emod_r[$mid]['pagef'];
if($pagef&&$r[$pagef])
{
	$r[$pagef]=str_replace('[!--empirenews.page--]','',$r[$pagef]);
	$r[$pagef]=str_replace('[/!--empirenews.page--]','',$r[$pagef]);
}
$url=ReturnClassLink($r[classid])."&nbsp;>&nbsp;".$fun_r['zw'];
//标题链接
$titleurl=sys_ReturnBqTitleLink($r);
//标题图片
if(empty($r[titlepic]))
{
	$r[titlepic]=$public_r[newsurl].'e/data/images/notimg.gif';
}
$bclassid=$class_r[$classid][bclassid];
@require(ECMS_PATH.'e/data/filecache/template/print'.$tempid.'.php');
db_close();
$empire=null;
?>