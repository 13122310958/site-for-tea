<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../../data/dbcache/class.php");
require("../../data/dbcache/MemberLevel.php");
require("../class/DownSysFun.php");
eCheckCloseMods('down');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
if(!$public_r['opengetdown'])
{
	printerror('CloseGetDown','',1);
}
//验证IP
//eCheckAccessDoIp('downinfo');
$id=(int)$_GET['id'];
$pathid=(int)$_GET['pathid'];
$classid=(int)$_GET['classid'];
if(!$classid||empty($class_r[$classid][tbname])||!$id)
{
	printerror('ExiestSoftid','',1);
}
$mid=$class_r[$classid][modid];
$tbname=$class_r[$classid][tbname];
$query="select * from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1";
$r=$empire->fetch1($query);
if(!$r['id']||$r['classid']!=$classid)
{
	printerror('ExiestSoftid','',1);
}
//副表
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
//区分下载地址
$path_r=explode("\r\n",$r[downpath]);
if(!$path_r[$pathid])
{
	printerror('ExiestSoftid','',1);
}
$showdown_r=explode("::::::",$path_r[$pathid]);
//下载权限
$downgroup=$showdown_r[2];
$user=array();
if($downgroup)
{
	$user=islogin();
}
//验证码
$ip=egetip();
$pass=md5(ReturnDownSysCheckIp()."wm_chief".$public_r[downpass].$user[userid]);
$p=$user[userid].":::".$user[rnd];
DownSoft($classid,$id,$pathid,$p,$pass);
db_close();
$empire=null;
?>