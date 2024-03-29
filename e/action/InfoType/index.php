<?php
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php');
require('../../class/t_functions.php');
require('../../data/dbcache/class.php');
require '../'.LoadLang('pub/fun.php');
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$ttid=(int)$_GET['ttid'];
if(empty($ttid))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$search='&ttid='.$ttid;
$mid=$class_tr[$ttid]['mid'];
if(empty($mid))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$ttr=$empire->fetch1("select typeid,tname,mid,yhid,tnum,listtempid,tpath,ttype,maxnum,reorder,tid,tbname,timg,intro,pagekey,listdt,repagenum from {$dbtbpre}enewsinfotype where typeid='$ttid'");
$tbname=$ttr['tbname'];
if(empty($ttr['typeid'])||empty($tbname)||InfoIsInTable($tbname))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
//是否支持动态页
if(empty($ttr['listdt'])&&!$ttr['repagenum'])
{
	$tturl=sys_ReturnBqInfoTypeUrl($ttid);
	Header("Location:$tturl");
	exit();
}
$GLOBALS['navclassid']=$ttid;
$url=ReturnInfoTypeLink($ttid);
$pagetitle=$ttr['tname'];
$pagekey=$ttr['pagekey'];
$pagedes=$ttr['intro'];
$classimg=$ttr['timg']?$ttr['timg']:$public_r[newsurl].'e/data/images/notimg.gif';

$add="ttid='$ttid'";
$have_class=1;
//排序
if(empty($ttr['reorder']))
{
	$addorder="newstime desc";
}
else
{
	$addorder=$ttr['reorder'];
}
//列表模板
$tempid=$ttr['listtempid'];
if(empty($tempid))
{
	printerror('ErrorUrl','',1);
}
$tempr=$empire->fetch1("select tempid,temptext,subnews,listvar,rownum,showdate,modid,subtitle,docode from ".GetTemptb("enewslisttemp")." where tempid='$tempid'");
if(empty($tempr[tempid]))
{
	printerror('ErrorUrl','',1);
}
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=$ttr['tnum'];//每页显示记录数
$page_line=16;//每页显示链接数
$offset=$page*$line;//总偏移量
//系统模型
$ret_r=ReturnReplaceListF($mid);
//优化
$yhadd='';
$yhid=$ttr['yhid'];
$yhvar='qlist';
if($yhid)
{
	$yhadd=ReturnYhSql($yhid,$yhvar,1);
}
//总数
$totalnum=(int)$_GET['totalnum'];
if($totalnum<1)
{
	$totalquery="select count(*) as total from {$dbtbpre}ecms_".$tbname." where ".$yhadd.$add;
	$num=$empire->gettotal($totalquery);
}
else
{
	$num=$totalnum;
}
$search.='&totalnum='.$num;
$query="select ".ReturnSqlListF($mid)." from {$dbtbpre}ecms_".$tbname." where ".$yhadd.$add;
$query.=" order by ".ReturnSetTopSql('list').$addorder." limit $offset,$line";
$sql=$empire->query($query);
//伪静态
$pagefunr=eReturnRewriteTitleTypeUrl($ttid,0);
$pagefunr['repagenum']=$ttr['repagenum'];
$pagefunr['dolink']=$public_r['newsurl'].$class_tr[$ttid]['tpath'].'/';
$pagefunr['dofile']='index';
$pagefunr['dotype']=$class_tr[$ttid]['ttype'];
//分页
if($pagefunr['rewrite']==1||$pagefunr['repagenum'])
{
	$listpage=InfoUsePage($num,$line,$page_line,$start,$page,$search,$pagefunr);
}
else
{
	$listpage=page1($num,$line,$page_line,$start,$page,$search);
}
//页面支持标签
if($public_r['dtcanbq'])
{
	$tempr[temptext]=DtNewsBq('list'.$tempid,$tempr[temptext],0);
}
else
{
	if($public_r['searchtempvar'])
	{
		$tempr[temptext]=ReplaceTempvar($tempr[temptext]);
	}
}
$listtemp=$tempr[temptext];
$rownum=$tempr[rownum];
if(empty($rownum))
{$rownum=1;}
$formatdate=$tempr[showdate];
$subnews=$tempr[subnews];
$subtitle=$tempr[subtitle];
$docode=$tempr[docode];
$modid=$tempr[modid];
$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tempr[listvar]);
//公共
$listtemp=str_replace('[!--newsnav--]',$url,$listtemp);//位置导航
$listtemp=Class_ReplaceSvars($listtemp,$url,$ttid,$pagetitle,$pagekey,$pagedes,$classimg,$addr,0);
$listtemp=str_replace('[!--page.stats--]','',$listtemp);
$listtemp=str_replace('[!--show.page--]',$listpage,$listtemp);
$listtemp=str_replace('[!--show.listpage--]',$listpage,$listtemp);
$listtemp=str_replace('[!--list.pageno--]',$page+1,$listtemp);
//取得列表模板
$list_exp="[!--empirenews.listtemp--]";
$list_r=explode($list_exp,$listtemp);
$listtext=$list_r[1];
$no=$offset+1;
$changerow=1;
while($r=$empire->fetch($sql))
{
	//替换列表变量
	$repvar=ReplaceListVars($no,$listvar,$subnews,$subtitle,$formatdate,$url,$have_class,$r,$ret_r,$docode);
	$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
	$changerow+=1;
	//超过行数
	if($changerow>$rownum)
	{
		$changerow=1;
		$string.=$listtext;
		$listtext=$list_r[1];
	}
	$no++;
}
//多余数据
if($changerow<=$rownum&&$listtext<>$list_r[1])
{
	$string.=$listtext;
}
$string=$list_r[0].$string.$list_r[2];
echo stripSlashes($string);
db_close();
$empire=null;
?>