<?php
exit();
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//初使化
$from=$_GET['from'];
if($_GET['first']==1)
{
	$rechecktablenum=0;
}
else
{
	$rechecktablenum=$_COOKIE['rechecktablenum'];
	$rechecktablenum+=1;
}
if($rechecktablenum>=$_COOKIE['retablenum'])
{
	$enews="ReNewsHtml";
	//操作日志
	insert_dolog("");
	echo"<script>alert('刷新信息页面成功!');parent.location.href='$from';</script>";
}
else
{
	//setcookie("rechecktablenum",$rechecktablenum,0,"/","");
}
db_close();
$empire=null;
?>