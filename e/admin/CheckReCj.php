<?php
exit();
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
	$recheckcjnum=0;
}
else
{
	$recheckcjnum=$_COOKIE['recheckcjnum'];
	$recheckcjnum+=1;
}
if($recheckcjnum>=$_COOKIE['recjnum'])
{
	$enews="ReNewsHtml";
	//操作日志
	        insert_dolog("");
	echo"<script>alert('所有节点采集完毕,请击相应的节点进入数据入库!');</script>";
}
else
{
	setcookie("recheckcjnum",$recheckcjnum,0,"/","");
}
db_close();
$empire=null;
?>