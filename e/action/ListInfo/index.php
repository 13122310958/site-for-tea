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
$classid=(int)$_GET['classid'];
if(empty($classid))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$search='&classid='.$classid;
$tbname=$class_r[$classid][tbname];
$mid=$class_r[$classid][modid];
if(empty($tbname)||empty($mid)||InfoIsInTable($tbname))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$cr=$empire->fetch1("select classid,classpagekey,intro,classimg,cgroupid,islist,classtempid,listdt,bdinfoid,repagenum,islast,infos from {$dbtbpre}enewsclass where classid='$classid'");
if(empty($cr['classid']))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
if($class_r[$classid][islast]&&$cr['bdinfoid'])
{
	printerror("ErrorUrl","history.go(-1)",1);
}
//是否支持动态页
if(empty($class_r[$classid]['listdt'])&&!$cr['repagenum'])
{
	$classurl=sys_ReturnBqClassname($cr,9);
	Header("Location:$classurl");
	exit();
}
//权限
if($cr['cgroupid'])
{
	$mgroupid=(int)getcvar('mlgroupid');
	if(!strstr($cr[cgroupid],','.$mgroupid.','))
	{
		printerror('NotLevelToClass','history.go(-1)',1);
	}
}
$GLOBALS['navclassid']=$classid;
$url=ReturnClassLink($classid);
$pagetitle=$class_r[$classid]['classname'];
$pagekey=$cr['classpagekey'];
$pagedes=$cr['intro'];
$classimg=$cr['classimg']?$cr['classimg']:$public_r[newsurl].'e/data/images/notimg.gif';
//---封面式---
if(!$class_r[$classid][islast]&&$cr['islist']!=1)
{
	if(empty($cr['listdt'])||$cr['islist']==3)
	{
		printerror("ErrorUrl","history.go(-1)",1);
	}
	if($cr[islist]==2)
	{
		$classtemp=GetClassText($classid);
		$dttempname='classpage'.$classid;
	}
	else
	{
		if(empty($cr['classtempid']))
		{
			printerror('ErrorUrl','',1);
		}
		$classtemp=GetClassTemp($cr['classtempid']);
		$dttempname='classtemp'.$cr['classtempid'];
	}
	$string=DtNewsBq($dttempname,$classtemp,0);
	$string=str_replace('[!--newsnav--]',$url,$string);//位置导航
	$string=Class_ReplaceSvars($string,$url,$classid,$pagetitle,$pagekey,$pagedes,$classimg,$addr,0);
	$string=str_replace('[!--page.stats--]','',$string);
	echo stripSlashes($string);
	exit();
}
//---列表式---
$add='';
//栏目
if($class_r[$classid][islast])//终极栏目
{
	$add.="classid='$classid'";
	$have_class=0;
}
else
{
	$add.=ReturnClass($class_r[$classid][sonclass]);
	$have_class=1;
}
//排序
if(empty($class_r[$classid][reorder]))
{
	$addorder="newstime desc";
}
else
{
	$addorder=$class_r[$classid][reorder];
}
//列表模板
$tempid=$class_r[$classid]['dtlisttempid']?$class_r[$classid]['dtlisttempid']:$class_r[$classid]['listtempid'];
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
$line=$class_r[$classid]['lencord'];//每页显示记录数
$page_line=16;//每页显示链接数
$offset=$page*$line;//总偏移量
//系统模型
$ret_r=ReturnReplaceListF($mid);
//优化
$yhadd='';
$yhid=$class_r[$classid][yhid];
$yhvar='qlist';
if($yhid)
{
	$yhadd=ReturnYhSql($yhid,$yhvar,1);
}
//总数
$totalnum=(int)$_GET['totalnum'];
if($totalnum<1)
{
	if($yhadd)
	{
		$totalquery="select count(*) as total from {$dbtbpre}ecms_".$tbname." where ".$yhadd.$add;
		$num=$empire->gettotal($totalquery);
	}
	else
	{
		$num=ReturnClassInfoNum($cr,0);
	}
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
$pagefunr=eReturnRewriteClassUrl($classid,0);
$pagefunr['repagenum']=$cr['repagenum'];
$pagefunr['dolink']=empty($class_r[$classid]['classurl'])?$public_r['newsurl'].$class_r[$classid]['classpath'].'/':$class_r[$classid]['classurl'].'/';
$pagefunr['dofile']='index';
$pagefunr['dotype']=$class_r[$classid]['classtype'];
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
$listtemp=Class_ReplaceSvars($listtemp,$url,$classid,$pagetitle,$pagekey,$pagedes,$classimg,$addr,0);
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