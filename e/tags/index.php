<?php
require('../class/connect.php');
require('../class/db_sql.php');
require('../class/functions.php');
require('../class/t_functions.php');
require('../data/dbcache/class.php');
require LoadLang('pub/fun.php');
$link=db_connect();
$empire=new mysqlquery();
if(!$public_r['opentags'])
{
	printerror('CloseTags','',1);
}
$add='';
$search='';
$GLOBALS['navclassid']=0;
//TAGS
$tagid=(int)$_GET['tagid'];
if($tagid)
{
	$tagr=$empire->fetch1("select tagname,num from {$dbtbpre}enewstags where tagid='$tagid'");
	if(!$tagr['tagname'])
	{
		printerror('HaveNotTags','',1);
	}
	$tagname=$tagr['tagname'];
	$num=$tagr['num'];
	$search.="&tagid=$tagid";
}
else
{
	$tagname=RepPostVar($_GET['tagname']);
	if(!$tagname)
	{
		printerror('HaveNotTags','',1);
	}
	$tagr=$empire->fetch1("select tagid,num from {$dbtbpre}enewstags where tagname='$tagname' limit 1");
	if(!$tagr['tagid'])
	{
		printerror('HaveNotTags','',1);
	}
	$tagid=$tagr['tagid'];
	$num=$tagr['num'];
	$search.="&tagname=$tagname";
}
//模型ID
$mid=(int)$_GET['mid'];
if($mid)
{
	if(empty($emod_r[$mid]['tbname']))
	{
		printerror('ErrorUrl','',1);
	}
	$add.=" and mid='$mid'";
	$search.='&mid='.$mid;
}
$pagetitle=$tagname;
$pagekey=$tagname;
$pagedes=$tagname;
$classimg=$public_r[newsurl].'e/data/images/notimg.gif';
$url="<a href='".ReturnSiteIndexUrl()."'>".$fun_r['index']."</a>&nbsp;>&nbsp;".$fun_r['TagsInfoList']."&nbsp;>&nbsp;".$tagname;
$pageecms=1;
$pageclassid=0;
$have_class=1;
//栏目
$trueclassid=0;
$classid=$_GET['classid'];
if($classid)
{
	$classid=RepPostVar($classid);
	if(strstr($classid,','))//多栏目
	{
		$son_r=sys_ReturnMoreClass($classid,1);
		$trueclassid=$son_r[0];
		$add.=' and ('.$son_r[1].')';
	}
	else
	{
		$trueclassid=intval($classid);
		if($class_r[$trueclassid][islast])//终极栏目
		{
			$add.=" and classid='$trueclassid'";
			$have_class=0;
		}
		else
		{
			$add.=' and '.ReturnClass($class_r[$trueclassid][sonclass]);
		}
		$pageclassid=$trueclassid;
		$GLOBALS['navclassid']=$trueclassid;
	}
	if(empty($class_r[$trueclassid][tbname]))
	{
		printerror('ErrorUrl','',1);
	}
	$search.='&classid='.$classid;
}
//时间
if($_GET['endtime'])
{
	$starttime=RepPostVar($_GET['starttime']);
	if(empty($starttime))
	{
		$starttime='0000-00-00';
	}
	$endtime=RepPostVar($_GET['endtime']);
	if(empty($endtime))
	{
		$endtime='0000-00-00';
	}
	if($endtime!='0000-00-00')
	{
		$add.=" and (newstime BETWEEN '".to_time($starttime." 00:00:00")."' and '".to_time($endtime." 23:59:59")."')";
		$search.='&starttime='.$starttime.'&endtime='.$endtime;
	}
}
//每页显示记录数
$line=(int)$_GET['line'];
if($line<1||$line>80)
{
	$line=intval($public_r['tagslistnum']);
}
if(empty($line))
{
	printerror('ErrorUrl','',1);
}
//列表模板
$tempid=(int)$_GET['tempid'];
if(empty($tempid))
{
	$tempid=$public_r['tagstempid'];
}
else
{
	DtTempIsClose($tempid,'listtemp');
}
if(empty($tempid))
{
	printerror('ErrorUrl','',1);
}
$tempr=$empire->fetch1("select tempid,temptext,subnews,listvar,rownum,showdate,modid,subtitle,docode from ".GetTemptb("enewslisttemp")." where tempid='$tempid'");
if(empty($tempr[tempid]))
{
	printerror('ErrorUrl','',1);
}
$search.='&line='.$line.'&tempid='.$tempid;
if(empty($mid))
{
	$mid=$tempr['modid'];
}
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$page_line=16;//每页显示链接数
$offset=$page*$line;//总偏移量
//系统模型
$ret_r=ReturnReplaceListF($mid);
//总数
if(!empty($add))
{
	$totalnum=(int)$_GET['totalnum'];
	if($totalnum<1)
	{
		$totalquery="select count(*) as total from {$dbtbpre}enewstagsdata where tagid='$tagid'".$add;
		$num=$empire->gettotal($totalquery);
	}
	else
	{
		$num=$totalnum;
	}
	$search.='&totalnum='.$num;
}
$query="select classid,id from {$dbtbpre}enewstagsdata where tagid='$tagid'".$add;
$query.=" order by newstime desc limit $offset,$line";
$sql=$empire->query($query);
if($tagr['tagid']&&empty($add)&&$search=='&tagname='.$tagname.'&line='.$public_r['tagslistnum'].'&tempid='.$public_r['tagstempid'])
{
	//伪静态
	$pagefunr=eReturnRewriteTagsUrl($tagid,$tagname,0);
	$pagefunr['repagenum']=0;
	//分页
	if($pagefunr['rewrite']==1)
	{
		$listpage=InfoUsePage($num,$line,$page_line,$start,$page,$search,$pagefunr);
	}
	else
	{
		$listpage=page1($num,$line,$page_line,$start,$page,$search);
	}
}
else
{
	$listpage=page1($num,$line,$page_line,$start,$page,$search);//分页
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
$listtemp=Class_ReplaceSvars($listtemp,$url,$pageclassid,$pagetitle,$pagekey,$pagedes,$classimg,$addr,$pageecms);
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
	if(empty($class_r[$r[classid]][tbname]))
	{
		continue;
	}
	$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]." where id='$r[id]' limit 1");
	if(empty($infor['id']))
	{
		continue;
	}
	//替换列表变量
	$repvar=ReplaceListVars($no,$listvar,$subnews,$subtitle,$formatdate,$url,$have_class,$infor,$ret_r,$docode);
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