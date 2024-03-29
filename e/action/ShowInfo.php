<?php
require('../class/connect.php');
require('../class/db_sql.php');
require('../class/functions.php');
require('../class/t_functions.php');
require LoadLang('pub/fun.php');
require('../data/dbcache/class.php');
require('../data/dbcache/MemberLevel.php');
$link=db_connect();
$empire=new mysqlquery();
$classid=(int)$_GET['classid'];
$id=(int)$_GET['id'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$mid=$class_r[$classid]['modid'];
$tbname=$class_r[$classid]['tbname'];
//验证IP
eCheckAccessDoIp('showinfo');
if(!$classid||!$id||!$mid||!$tbname||InfoIsInTable($tbname))
{
	printerror('此信息不存在','',1,0,1);
}
$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1");
if(!$r['id']||$classid!=$r['classid'])
{
	printerror('此信息不存在','',1,0,1);
}
//外部链接
if($r['isurl'])
{
	$titleurl=$r['titleurl'];
	Header("Location:$titleurl");
	exit();
}
//是否支持动态内容页
if($class_r[$classid]['showdt']!=2)
{
	$titleurl=sys_ReturnBqTitleLink($r);
	Header("Location:$titleurl");
	exit();
}
//副表
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$r['stb']." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
//权限
if($r['groupid']||$class_r[$classid]['cgtoinfo'])
{
	define('empirecms','wm_chief');
	define('PageCheckLevel','wm_chief');
	$check_tbname=$tbname;
	$check_infoid=$id;
	$check_classid=$classid;
	$check_path="../../";
	$checkinfor=$r;
	@include("../class/CheckLevel.php");
}
//存文本
if($emod_r[$mid]['savetxtf'])
{
	$stf=$emod_r[$mid]['savetxtf'];
	if($r[$stf])
	{
		$r[$stf]=GetTxtFieldText($r[$stf]);
	}
}
//初始值
$search="&classid=$classid&id=$id";
$line=1;
$start=0;
$page_line=6;//每页显示链接数
$offset=$page*$line;//总偏移量
$GLOBALS['navclassid']=$r[classid];
$GLOBALS['navinfor']=$r;
//取得内容模板
$r[newstempid]=$r[newstempid]?$r[newstempid]:$class_r[$r[classid]][newstempid];
$newstemp_r=$empire->fetch1("select tempid,temptext,showdate from ".GetTemptb("enewsnewstemp")." where tempid='$r[newstempid]'");

//替换模板变量
function DtGetHtml($add,$newstemp_r,$mid,$tbname,$line,$page_line,$start,$page,$search){
	global $public_r,$class_r,$class_zr,$class_tr,$fun_r,$empire,$dbtbpre,$emod_r,$level_r;
	//更新点击
	$empire->query("update {$dbtbpre}ecms_".$tbname." set onclick=onclick+1 where id='$add[id]' limit 1");
	$add['onclick']=$add['onclick']+1;
	//模板参数
	$newstemptext=$newstemp_r[temptext];
	$formatdate=$newstemp_r[showdate];
	//页面
	$pagetitle=ehtmlspecialchars($add[title]);
	$url=ReturnClassLink($add[classid]);//导航
	$newstemptext=DtInfo_ReplaceSvars($newstemptext,$url,$add[classid],$pagetitle,$add[keyboard],$pagetitle);
	//相关信息
	if(strstr($newstemptext,'[!--other.link--]'))
	{
    	$keyboardtext=GetKeyboard($add[keyboard],$add[keyid],$add[classid],$add[id],$class_r[$add[classid]][link_num]);
	}
	//分页字段
	$ptitle=$add['title'];
	$truepage='';
	$titleselect='';
	$expage='[!--empirenews.page--]';//分页符
	$pf=$emod_r[$mid]['pagef'];
	if($pf&&strstr($add[$pf],$expage))//有分页
	{
		$n_r=explode($expage,$add[$pf]);
		$thispagenum=count($n_r);
		if($page<0||$page>$thispagenum-1)
		{
			$page=0;
		}
		$add[$pf]=$n_r[$page];
		if($page)
		{
			$ti_r=explode('[/!--empirenews.page--]',$n_r[$page]);
			if(count($ti_r)>=2)
			{
				$ptitle=$ti_r[0];
				$add[$pf]=$ti_r[1];
			}
			else
			{
				$ptitle=$add['title'].'('.($page+1).')';
			}
		}
		//伪静态
		$pagefunr=eReturnRewriteInfoUrl($add['classid'],$add['id'],0);
		$pagefunr['repagenum']=0;
		//取得分页
		$truepage=InfoUsePage($thispagenum,$line,$page_line,$start,$page,$search,$pagefunr);
		//下拉式分页
		if(strstr($newstemptext,'[!--title.select--]'))
		{
			for($j=0;$j<$thispagenum;$j++)
			{
				$spurl=eReturnRewritePageLink($pagefunr,$j);
				if($j==0)
				{
					$sptitle=$add[title];
				}
				else
				{
					$ti_r=explode('[/!--empirenews.page--]',$n_r[$j]);
					$sptitle=count($ti_r)>=2?$ti_r[0]:$add[title].'('.($j+1).')';
				}
				$select='';
				if($page==$j)
				{
					$ptitle=$sptitle;
					$select=' selected';
				}
				$titleselect.='<option value="'.$spurl.'"'.$select.'>'.$sptitle.'</option>';
			}
			$titleselect='<select name="titleselect" onchange="self.location.href=this.options[this.selectedIndex].value">'.$titleselect.'</select>';
		}
		//下一页链接
		if($page==$thispagenum-1)
		{
			$thisnextlink=eReturnRewritePageLink($pagefunr,0);
		}
		else
		{
			$thisnextlink=eReturnRewritePageLink($pagefunr,$page+1);
		}
	}
	//返回替换验证字符
	$docheckrep=ReturnCheckDoRepStr();
	if($add[newstext])
	{
		if(empty($public_r['dorepword'])&&$docheckrep[3])
		{
			$add[newstext]=ReplaceWord($add[newstext]);//过滤字符
		}
		if(empty($public_r['dorepkey'])&&$docheckrep[4]&&!empty($add[dokey]))//替换关键字
		{
			$add[newstext]=ReplaceKey($add['newstext'],$add['classid']);
		}
		if($public_r['opencopytext'])
		{
			$add[newstext]=AddNotCopyRndStr($add[newstext]);//随机复制字符
		}
	}
	//变量
	$tempf=$emod_r[$mid]['tempf'];
	$fr=explode(',',$tempf);
	$fcount=count($fr)-1;
	//变量替换
	$newstempstr=$newstemptext;//模板
	for($i=1;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$value=$add[$f];
		if($f=='downpath')//下载地址
		{
			if(strstr($newstemptext,'[!--downpath--]'))
			{
				$value=ReturnDownSoftHtml($add);
			}
		}
		elseif($f=='onlinepath')//观看地址
		{
			if(strstr($newstemptext,'[!--onlinepath--]'))
			{
				$value=ReturnOnlinepathHtml($add);
			}
		}
		elseif($f=='morepic')//图片集
		{
			if(strstr($newstemptext,'[!--morepic--]'))
			{
				$value=ReturnMorepicpathHtml($add);
			}
		}
		elseif($f=='newstime')//时间
		{
			if(strstr($newstemptext,'[!--newstime--]'))
			{
				$value=date($formatdate,$value);
			}
		}
		elseif($f=='befrom')//信息来源
		{
			if($docheckrep[1]&&strstr($newstemptext,'[!--befrom--]'))
			{
				$value=ReplaceBefrom($value);
			}
		}
		elseif($f=='writer')//作者
		{
			if($docheckrep[2]&&strstr($newstemptext,'[!--writer--]'))
			{
				$value=ReplaceWriter($value);
			}
		}
		elseif($f=='titlepic')//标题图片
		{
			if(empty($value))
			{$value=$public_r[newsurl].'e/data/images/notimg.gif';}
		}
		elseif($f=='title')//标题
		{
		}
		else//正常字段
		{
			if(!strstr($emod_r[$mid]['editorf'],','.$f.','))
			{
				if(strstr($emod_r[$mid]['tobrf'],','.$f.','))//加br
				{
					$value=nl2br($value);
				}
				if(!strstr($emod_r[$mid]['dohtmlf'],','.$f.','))//去除html
				{
					$value=RepFieldtextNbsp(ehtmlspecialchars($value));
				}
			}
		}
		$newstempstr=str_replace('[!--'.$f.'--]',$value,$newstempstr);
	}
	//固定变量
	$newstempstr=str_replace('[!--id--]',$add[id],$newstempstr);
	$newstempstr=str_replace('[!--classid--]',$add[classid],$newstempstr);
	$newstempstr=str_replace('[!--class.name--]',$class_r[$add[classid]][classname],$newstempstr);
	$newstempstr=str_replace('[!--ttid--]',$add[ttid],$newstempstr);
	$newstempstr=str_replace('[!--tt.name--]',$class_tr[$add[ttid]][tname],$newstempstr);
	$newstempstr=str_replace('[!--onclick--]',$add[onclick],$newstempstr);
	$newstempstr=str_replace('[!--userfen--]',$add[userfen],$newstempstr);
	$newstempstr=str_replace('[!--username--]',$add[username],$newstempstr);
	//带链接的用户名
	if($add[ismember]==1&&$add[userid])
	{
		$newstempstr=str_replace('[!--linkusername--]',"<a href='".$public_r[newsurl]."e/space/?userid=".$add[userid]."' target=_blank>".$add[username]."</a>",$newstempstr);
	}
	else
	{
		$newstempstr=str_replace('[!--linkusername--]',$add[username],$newstempstr);
	}
	$newstempstr=str_replace('[!--userid--]',$add[userid],$newstempstr);
	$newstempstr=str_replace('[!--other.link--]',$keyboardtext,$newstempstr);
	$newstempstr=str_replace('[!--news.url--]',$public_r[newsurl],$newstempstr);
	$newstempstr=str_replace('[!--plnum--]',$add[plnum],$newstempstr);
	$newstempstr=str_replace('[!--totaldown--]',$add[totaldown],$newstempstr);
	$newstempstr=str_replace('[!--keyboard--]',$add[keyboard],$newstempstr);
	//链接
	$titleurl=sys_ReturnBqTitleLink($add);
	$newstempstr=str_replace('[!--titleurl--]',$titleurl,$newstempstr);
	$newstempstr=str_replace('[!--page.stats--]','',$newstempstr);
	$classurl=sys_ReturnBqClassname($add,9);
	$newstempstr=str_replace('[!--class.url--]',$classurl,$newstempstr);
	//下一篇
	if(strstr($newstemptext,'[!--info.next--]'))
	{
		$next_r=$empire->fetch1("select isurl,titleurl,classid,id,title from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id>$add[id] and classid='$add[classid]' order by id limit 1");
		if(empty($next_r[id]))
		{
			$infonext="<a href='".$classurl."'>".$fun_r['HaveNoNextLink']."</a>";
		}
		else
		{
			//链接
			$nexttitleurl=sys_ReturnBqTitleLink($next_r);
			$infonext="<a href='".$nexttitleurl."'>".$next_r[title]."</a>";
		}
		$newstempstr=str_replace('[!--info.next--]',$infonext,$newstempstr);
	}
	//上一篇
	if(strstr($newstemptext,'[!--info.pre--]'))
	{
		$next_r=$empire->fetch1("select isurl,titleurl,classid,id,title from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id<$add[id] and classid='$add[classid]' order by id desc limit 1");
		if(empty($next_r[id]))
		{
			$infonext="<a href='".$classurl."'>".$fun_r['HaveNoNextLink']."</a>";
		}
		else
		{
			//链接
			$nexttitleurl=sys_ReturnBqTitleLink($next_r);
			$infonext="<a href='".$nexttitleurl."'>".$next_r[title]."</a>";
		}
		$newstempstr=str_replace('[!--info.pre--]',$infonext,$newstempstr);
	}
	//投票
	if(strstr($newstemptext,'[!--info.vote--]'))
	{
		$myvotetext=sys_GetInfoVote($add[classid],$add[id]);
		$newstempstr=str_replace('[!--info.vote--]',$myvotetext,$newstempstr);
	}
	//评分
	if(strstr($newstemptext,'[!--pinfopfen--]'))
	{
		$pinfopfen=$add[infopfennum]?round($add[infopfen]/$add[infopfennum]):0;
		$newstempstr=str_replace('[!--pinfopfen--]',$pinfopfen,$newstempstr);
		$newstempstr=str_replace('[!--infopfennum--]',$add[infopfennum],$newstempstr);
	}
	$string=$newstempstr;
	//替换变量
	$string=str_replace('[!--p.title--]',strip_tags($ptitle),$string);
	$string=str_replace('[!--next.page--]',$thisnextlink,$string);
	$string=str_replace('[!--page.url--]',$truepage,$string);
	$string=str_replace('[!--title.select--]',$titleselect,$string);
	return $string;
}

if(empty($newstemp_r['tempid']))
{
	printerror('ErrorUrl','',1);
}
//页面支持标签
if($public_r['dtncanbq'])
{
	$newstemp_r[temptext]=DtNewsBq('text'.$newstemp_r[tempid],$newstemp_r[temptext],1);
}
else
{
	if($public_r['searchtempvar'])
	{
		$newstemp_r[temptext]=ReplaceTempvar($newstemp_r[temptext]);
	}
}
$string=DtGetHtml($r,$newstemp_r,$mid,$tbname,$line,$page_line,$start,$page,$search);
echo stripSlashes($string);
db_close();
$empire=null;
?>