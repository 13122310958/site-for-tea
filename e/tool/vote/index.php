<?php
require('../../class/connect.php');
require('../../class/db_sql.php');
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$voteid=(int)$_GET['voteid'];
if(empty($voteid))
{
	printerror("NotVote","history.go(-1)",9);
}
$r=$empire->fetch1("select voteid,title,votenum,votetext,voteclass,addtime from {$dbtbpre}enewsvote where voteid='$voteid'");
if(empty($r['voteid'])||empty($r['votetext']))
{
	printerror("NotVote","history.go(-1)",9);
}
$r_exp="\r\n";
$f_exp="::::::";
if($r['voteclass'])
{
	$voteclass="多选";
}
else
{
	$voteclass="单选";
}
//导入模板
require(ECMS_PATH.'e/template/tool/vote.php');
db_close();
$empire=null;
?>