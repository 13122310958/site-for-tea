<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../data/dbcache/class.php");
require("../member/class/user.php");
require("../data/dbcache/MemberLevel.php");
$link=db_connect();
$empire=new mysqlquery();
$userid=0;
$username='';
$spacestyle='';
require('CheckUser.php');//��֤�û�
$p=RepPostVar($_GET['p']);
if(!$p)
{
	printerror('ErrorUrl','',1);
}
$pagename='';
$pagetext='';
if($groupid)
{
	$record="<!--record-->";
	$field="<!--field--->";
	$memberformid=GetMemberFormId($groupid);
	$memberformr=$empire->fetch1("select viewenter from {$dbtbpre}enewsmemberform where fid='$memberformid'");
	$flike=$field.$p.$record;
	if(strstr($memberformr['viewenter'],$flike))
	{
		$dofr=explode($flike,$memberformr['viewenter']);
		if(strstr($dofr[0],$record))
		{
			$dofr1=explode($record,$dofr[0]);
			$last=count($dofr1)-1;
			$pagename=$dofr1[$last];
		}
		else
		{
			$pagename=$dofr[0];
		}
		$pagetext=$addur[$p];
	}
}
require('template/'.$spacestyle.'/page.temp.php');
db_close();
$empire=null;
?>