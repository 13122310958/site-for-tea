<?php
require("../class/connect.php");
include("../class/db_sql.php");
$link=db_connect();
$empire=new mysqlquery();
//关闭
if($public_r['addnews_ok'])
{
	printerror("NotOpenCQInfo","",9);
}
$userid=(int)$_GET['userid'];
$username=$_GET['username'];
$rnd=$_GET['rnd'];
$ecms=$_GET['ecms'];
$classid=(int)$_GET['classid'];
$infoid=(int)$_GET['infoid'];
$filepass=$_GET['filepass'];
$type=$_GET['type'];
if(!$classid||!$filepass)
{
	printerror("ErrorUrl","",9);
}
$pr=$empire->fetch1("select qaddtran,qaddtransize,qaddtranimgtype,qaddtranfile,qaddtranfilesize,qaddtranfiletype from {$dbtbpre}enewspublic limit 1");
if($type==1)
{
	if(!$pr['qaddtran'])
	{
		printerror("CloseQTranPic","",9);
	}
	$filetype=$pr['qaddtranimgtype'];
	$filesize=$pr['qaddtransize'];
	$word="上传图片";
}
elseif($type==2)
{
	if(!$pr['qaddtranfile'])
	{
		printerror("CloseQTranFile","",9);
	}
	$filetype="|.swf|";
	$filesize=$pr['qaddtranfilesize'];
	$word="上传FLASH";
}
else
{
	if(!$pr['qaddtranfile'])
	{
		printerror("CloseQTranFile","",9);
	}
	$filetype=$pr['qaddtranfiletype'];
	$filesize=$pr['qaddtranfilesize'];
	$word="上传附件";
}
$filetype=substr($filetype,1,strlen($filetype));
$filetype=substr($filetype,0,strlen($filetype)-1);
$filetype=str_replace("|",",",$filetype);
if($ecms)
{
	$enews="MHtmlareaTranPic";
}
else
{
	$enews="MTranFile";
}
//导入模板
require(ECMS_PATH.'e/template/DoInfo/tran.php');
db_close();
$empire=null;
?>