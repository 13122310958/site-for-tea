<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../class/delpath.php");
require("../class/copypath.php");
require LoadLang("pub/fun.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
$link=db_connect();
$empire=new mysqlquery();
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
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

if($enews=="ReListHtml")//刷新信息列表
{
	$classid=$_GET['classid'];
	ReListHtml($classid,0);
}
elseif($enews=="AddPostUrlData")//初使化远程发布
{
	$postdata=$_POST['postdata'];
	AddPostUrlData($postdata,$logininid,$loginin);
}
elseif($enews=="PostUrlData")//远程发布
{
	$start=$_GET['start'];
	$rnd=$_GET['rnd'];
	PostUrlData($start,$rnd,$logininid,$loginin);
}
elseif($enews=="ChangeEnewsData")//更新缓存
{
	ChangeEnewsData($logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>