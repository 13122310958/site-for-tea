<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
$link=db_connect();
$empire=new mysqlquery();
$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
//变量
$onclick=(int)$_GET['onclick'];
$down=(int)$_GET['down'];
$plnum=(int)$_GET['plnum'];
$pfen=(int)$_GET['pfen'];
$pfennum=(int)$_GET['pfennum'];
$diggtop=(int)$_GET['diggtop'];
$diggdown=(int)$_GET['diggdown'];
$classf='tid,tbname';
if($plnum)
{
	$classf.=',checkpl';
}
$cr=$empire->fetch1("select ".$classf." from {$dbtbpre}enewsclass where classid='$classid' limit 1");
if(empty($cr['tbname']))
{
	exit();
}
$selectf='';
$f=array();
$divname=array();
$dh='';
if($onclick)//浏览数
{
	$selectf.=$dh.'onclick';
	$dh=',';
	$f[]='onclick';
	$divname[]='onclick';
}
if($down)//下载数
{
	$selectf.=$dh.'totaldown';
	$dh=',';
	$f[]='totaldown';
	$divname[]='down';
}
$pl=0;
if($plnum)//评论数
{
	if($cr['checkpl'])
	{
		$selectf.=$dh.'restb';
	}
	else
	{
		$selectf.=$dh.'plnum';
	}
	$dh=',';
	$f[]='plnum';
	$divname[]='plnum';
}
if($pfen)//评分数
{
	$selectf.=$dh.'infopfen,infopfennum';
	$dh=',';
	$f[]='avepfen';
	$divname[]='pfen';
}
if($pfennum)//评分人数
{
	if(!$pfen)
	{
		$selectf.=$dh.'infopfennum';
		$dh=',';
	}
	$f[]='infopfennum';
	$divname[]='pfennum';
}
if($diggtop)//digg顶数
{
	$selectf.=$dh.'diggtop';
	$dh=',';
	$f[]='diggtop';
	$divname[]='diggtop';
}
if($diggdown)//digg踩数
{
	$selectf.=$dh.'diggdown';
	$dh=',';
	$f[]='diggdown';
	$divname[]='diggdown';
}
if(empty($selectf))
{
	exit();
}
$r=$empire->fetch1("select ".$selectf." from {$dbtbpre}ecms_".$cr['tbname']." where id='$id' limit 1");
//统计浏览次数
if($_GET['addclick']==1)
{
	$empire->query("update {$dbtbpre}ecms_".$cr['tbname']." set onclick=onclick+1 where id='$id' limit 1");
}
$r['onclick']=$r['onclick']+1;
if($cr['checkpl'])
{
	$pubid=ReturnInfoPubid(0,$id,$cr['tid']);
	$pl=$empire->gettotal("select count(*) as total from {$dbtbpre}enewspl_".$r['restb']." where pubid='$pubid' and checked=0");
	$r['plnum']=$pl;
}
if($pfen)
{
	$r['avepfen']=$r['infopfennum']?round($r['infopfen']/$r['infopfennum']):0;
}
db_close();
$empire=null;
$count=count($divname);
for($i=0;$i<$count;$i++)
{
	$fname=$f[$i];
	echo 'document.getElementById("'.$divname[$i].'showdiv").innerHTML="'.$r[$fname].'";';
}
?>