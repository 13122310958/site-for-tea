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
require("../class/cjfun.php");
if($enews=="CjUrl")//开始采集
{
	$classid=$_GET[classid];
	$start=$_GET['start'];
	$checkrnd=$_GET['checkrnd'];
	CJUrl($classid,$start,$checkrnd,$logininid,$loginin);
}
elseif($enews=="ViewCjList")//采集列表
{
	$classid=$_GET[classid];
	ViewCjList($classid,$logininid,$loginin);
}
elseif($enews=="ViewCjUrl")//输出预览内容地址
{
	$classid=$_GET[classid];
	$listpage=$_GET[listpage];
	ViewCjUrl($classid,$listpage,$logininid,$loginin);
}
elseif($enews=="GetNewsInfo")//开始采集页面
{
	$classid=$_GET[classid];
	$checkrnd=$_GET[checkrnd];
	$start=$_GET[start];
	GetNewsInfo($classid,$checkrnd,$start,$logininid,$loginin);
}
elseif($enews=="ViewGetNewsInfo")//输入预览内容文件
{
	$classid=$_GET[classid];
	$newspage=$_GET['newspage'];
	ViewGetNewsInfo($classid,$newspage,$logininid,$loginin);
}
elseif($enews=="CjNewsIn_all")//采集全部入库
{
	$classid=$_GET['classid'];
	$checked=$_GET['checked'];
	$start=$_GET['start'];
	$uptime=$_GET['uptime'];
	CjNewsIn_all($classid,$checked,$uptime,$start,$logininid,$loginin);
}
elseif($enews=="CjNewsIn")//采集入库
{
	$classid=$_POST[classid];
	$id=$_POST[id];
	$checked=$_POST[checked];
	$uptime=$_POST['uptime'];
	CjNewsIn($classid,$id,$checked,$uptime,$logininid,$loginin);
}
elseif($enews=="EditCjNews")//修改采集信息
{
	$newstext=$_POST[newstext];
	EditCjNews($_POST,$newstext,$logininid,$loginin);
}
elseif($enews=="DelCjNews")//删除采集信息
{
	$classid=$_GET[classid];
	$id=$_GET[id];
	DelCjNews($classid,$id,$logininid,$loginin);
}
elseif($enews=="DelCjNews_all")//批量删除采集信息
{
	$classid=$_POST[classid];
	$id=$_POST[id];
	DelCjNews_all($classid,$id,$logininid,$loginin);
}
elseif($enews=="LoadOutCj")//导出采集规则
{
	LoadOutCj($_GET['classid'],$logininid,$loginin);
}
elseif($enews=="LoadInCj")//导入采集规则
{
	$file=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
	LoadInCj($_POST,$file,$file_name,$file_type,$file_size,$logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>