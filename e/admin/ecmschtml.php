<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
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
require("../class/chtmlfun.php");
if($enews=="ReNewsHtml")//刷新内容页面
{
	$start=$_GET['start'];
	$classid=$_GET['classid'];
	$from=$_GET['from'];
	$retype=$_GET['retype'];
	$startday=$_GET['startday'];
	$endday=$_GET['endday'];
	$startid=$_GET['startid'];
	$endid=$_GET['endid'];
	$tbname=$_GET['tbname'];
	$havehtml=$_GET['havehtml'];
	ReNewsHtml($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$havehtml);
}
elseif($enews=="ReListHtml_all")//刷新所有列表
{
	$start=$_GET['start'];
	$do=$_GET['do'];
	$from=$_GET['from'];
	ReListHtml_all($start,$do,$from);
}
elseif($enews=="ReZtListHtml_all")//刷新所有专题页面
{
	$start=$_GET['start'];
	$do=$_GET['do'];
	$from=$_GET['from'];
	ReZtListHtml_all($start,$do,$from);
}
elseif($enews=="ReTtListHtml_all")//刷新所有标题分类页面
{
	$start=$_GET['start'];
	$do=$_GET['do'];
	$from=$_GET['from'];
	ReTtListHtml_all($start,$do,$from);
}
elseif($enews=="ReAllNewsJs")//刷新所有信息js
{
	$start=$_GET['start'];
	$do=$_GET['do'];
	$from=$_GET['from'];
	ReAllNewsJs($start,$do,$from);
}
elseif($enews=="ReIndex")//刷新首页
{
	ReIndex();
}
elseif($enews=="ReUserpageAll")//批量刷新自定义页面
{
	ReUserpageAll($_GET['start'],$_GET['from'],$logininid,$loginin);
}
elseif($enews=="ReUserlistAll")//批量刷新自定义信息列表
{
	$start=$_GET['start'];
	$from=$_GET['from'];
	ReUserlistAll($start,$from,$logininid,$loginin);
}
elseif($enews=="ReUserjsAll")//批量刷新自定义JS
{
	$start=$_GET['start'];
	$from=$_GET['from'];
	ReUserjsAll($start,$from,$logininid,$loginin);
}
elseif($enews=="ReHot_NewNews")//刷新最新信息与热门信息JS
{
	ReHot_NewNews();
}
elseif($enews=="ReSpAll")//批量刷新碎片文件
{
	ReSpAll($_GET['start'],$_GET['from'],$logininid,$loginin);
}
elseif($enews=='ReSingleInfo')//刷新单信息页面
{
	ReSingleInfo($logininid,$loginin);
}
elseif($enews=="ReZtHtml")//刷新专题
{
	$ztid=$_GET['ztid'];
	$ecms=$_GET['ecms'];
	ReZtHtml($ztid,$ecms);
}
elseif($enews=="ReTtHtml")//刷新标题分类
{
	$typeid=$_GET['typeid'];
	ReTtHtml($typeid);
}
elseif($enews=="ReSingleJs")//刷新单个栏目JS
{
	$classid=$_GET['classid'];
	$doing=$_GET['doing'];
	ReSingleJs($classid,$doing);
}
elseif($enews=="ReDtPage")//批量更新动态页面
{
	ReDtPage($logininid,$loginin);
}
elseif($enews=="GoReListHtmlMore")//初使化刷新多栏目
{
	$classid=$_POST['classid'];
	$gore=$_POST['gore'];
	$from=$_POST['from'];
	$ecms=$_POST['ecms'];
	GoReListHtmlMore($classid,$gore,$from,$ecms);
}
elseif($enews=="GoReListHtmlMoreA")//初使化刷新多栏目(管理栏目)
{
	$classid=$_POST['reclassid'];
	$gore=$_POST['gore'];
	$from=$_POST['from'];
	$ecms=$_POST['ecms'];
	GoReListHtmlMore($classid,$gore,$from,$ecms);
}
elseif($enews=="ReListHtmlMore")//刷新多栏目
{
	$start=$_GET['start'];
	$classid=$_GET['classid'];
	$from=$_GET['from'];
	ReListHtmlMore($start,$classid,$from);
}
elseif($enews=="ReListZtHtmlMore")//刷新多专题
{
	$start=$_GET['start'];
	$classid=$_GET['classid'];
	$from=$_GET['from'];
	$ecms=$_GET['ecms'];
	ReListZtHtmlMore($start,$classid,$from,$ecms);
}
elseif($enews=="ReListTtHtmlMore")//刷新多标题分类
{
	$start=$_GET['start'];
	$classid=$_GET['classid'];
	$from=$_GET['from'];
	ReListTtHtmlMore($start,$classid,$from);
}
elseif($enews=="ReClassPath")//恢复栏目目录
{
	$start=$_GET['start'];
	ReClassPath($start);
}
elseif($enews=='UpdateClassInfosAll')//更新栏目信息数
{
	UpdateClassInfosAll($_GET);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>