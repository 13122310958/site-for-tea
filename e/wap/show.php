<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../data/dbcache/class.php");
$link=db_connect();
$empire=new mysqlquery();
define('WapPage','show');
$usewapstyle='';
$wapstyle=0;
$pr=array();
require("wapfun.php");
$classid=(int)$_GET['classid'];
$id=(int)$_GET['id'];
if(!$classid||!$class_r[$classid]['tbname']||!$id||InfoIsInTable($class_r[$classid]['tbname']))
{
	DoWapShowMsg('�����Ե����Ӳ�����','index.php?style=$wapstyle');
}
$cpage=(int)$_GET['cpage'];
$cid=(int)$_GET['cid'];
$bclassid=(int)$_GET['bclassid'];
if(empty($cid))
{
	$cid=$classid;
}
$listurl="list.php?style=".$wapstyle."&amp;page=".$cpage."&amp;classid=".$cid."&amp;bclassid=".$bclassid;
$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid]['tbname']." where id='$id' limit 1");
if(!$r['id']||$classid!=$r[classid])
{
	DoWapShowMsg('�����Ե����Ӳ�����',$listurl);
}
if($r['groupid']||$class_r[$classid]['cgtoinfo'])
{
	DoWapShowMsg('����Ϣ���ܲ鿴',$listurl);
}
//ϵͳģ��
$modid=$class_r[$classid][modid];
//����
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($modid)." from {$dbtbpre}ecms_".$class_r[$classid]['tbname']."_data_".$r[stb]." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
$ret_r=ReturnAddF($modid,1);

$pagetitle=DoWapClearHtml($r['title']);
//���ı�����
$savetxtf=$emod_r[$modid]['savetxtf'];
if($savetxtf&&$r[$savetxtf])
{
	$r[$savetxtf]=GetTxtFieldText($r[$savetxtf]);
}
//��ҳ�ֶ�
$pagef=$emod_r[$modid]['pagef'];
if($pagef&&$r[$pagef])
{
	//�滻����ҳ��
	$r[$pagef]=str_replace('[!--empirenews.page--]','',$r[$pagef]);
	$r[$pagef]=str_replace('[/!--empirenews.page--]','',$r[$pagef]);
}
require('template/'.$usewapstyle.'/show.temp.php');
db_close();
$empire=null;
?>