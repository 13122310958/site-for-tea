<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../../data/dbcache/class.php");
require("../../data/dbcache/MemberLevel.php");
require("../class/DownSysFun.php");
eCheckCloseMods('movie');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$ecmsreurl=2;
//验证IP
eCheckAccessDoIp('onlineinfo');
$id=(int)$_GET['id'];
$pathid=(int)$_GET['pathid'];
$classid=(int)$_GET['classid'];

//扣点函数
function ViewOnlineKFen($showdown_r,$u,$userid,$classid,$id,$pathid,$r){
	global $level_r,$class_r,$dbtbpre,$public_r,$empire,$have_bak,$have_fen;
	if($showdown_r[2])
	{
		//下载次数限制
		$setuserday="";
		if($level_r[$u['groupid']][daydown])
		{
			$setuserday=DoCheckMDownNum($userid,$u['groupid'],1);
		}
		//点数是否足够
		$showdown_r[3]=intval($showdown_r[3]);
		if($showdown_r[3])
		{
			if($have_fen==1)
			{
				//去除点数
				$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userfen')."=".egetmf('userfen')."-".$showdown_r[3]." where ".egetmf('userid')."='$userid'");
			}
			if($have_bak==0)
			{
				//备份下载记录
				$utfusername=$u['username'];
				BakDown($classid,$id,$pathid,$userid,$utfusername,$r[title],$showdown_r[3],1);
			}
		}
		//更新用户下载次数
		if($setuserday)
		{
			$usql=$empire->query($setuserday);
		}
	}
	//总下载数据增一
    $usql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]." set totaldown=totaldown+1 where id='$id'");
}

/*
来源识别
if(!strstr($_SERVER['HTTP_REFERER'],$public_r[newsurl]))
{
	exit();
}
*/
if(!$classid||empty($class_r[$classid][tbname])||!$id)
{
	echo"<script>alert('此影片不存在');window.close();</script>";
	exit();
}
$mid=$class_r[$classid][modid];
$tbname=$class_r[$classid][tbname];
$query="select * from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1";
$r=$empire->fetch1($query);
if(!$r['id']||$r['classid']!=$classid)
{
	echo"<script>alert('此影片不存在');window.close();</script>";
	exit();
}
//副表
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
//区分下载地址
$path_r=explode("\r\n",$r[onlinepath]);
if(!$path_r[$pathid])
{
	echo"<script>alert('此影片不存在');window.close();</script>";
	exit();
}
$showdown_r=explode("::::::",$path_r[$pathid]);
//下载权限
$u=array();
$downgroup=$showdown_r[2];
if($downgroup)
{
	$user=islogin();
	//取得会员资料
	$u=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$user[userid]' and ".egetmf('rnd')."='$user[rnd]' limit 1");
	if(empty($u['userid']))
	{
		echo"<script>alert('同一帐号，只能一人在线');window.close();</script>";
        exit();
    }
	//下载次数限制
	if($level_r[$u['groupid']][daydown])
	{
		$setuserday=DoCheckMDownNum($user[userid],$u['groupid'],2);
		if($setuserday=='error')
		{
			echo"<script>alert('您的下载与观看次数已超过系统限制(".$level_r[$u['groupid']][daydown]." 次)!');window.close();</script>";
			exit();
		}
	}
	if($level_r[$downgroup][level]>$level_r[$u['groupid']][level])
	{
		echo"<script>alert('您的会员级别不足(".$level_r[$downgroup][groupname].")，没有观看此影片的权限!');window.close();</script>";
            exit();
	}
	//点数是否足够
	$have_bak=0;
	$have_fen=0;
	if($showdown_r[3])
	{
		//---------是否有历史记录
			$bakr=$empire->fetch1("select id,truetime from {$dbtbpre}enewsdownrecord where id='$id' and classid='$classid' and userid='$user[userid]' and pathid='$pathid' and online=1 order by truetime desc limit 1");
			if($bakr[id]&&(time()-$bakr[truetime]<=$public_r[redodown]*3600))
			{
				$have_bak=1;
			}
			else
			{
				//包月卡
				if($u['userdate']-time()>0)
				{}
				//点数
				else
				{
			       if($showdown_r[3]>$u['userfen'])
			       {
					echo"<script>alert('您的点数不足 $showdown_r[3] 点，无法观看此影片');window.close();</script>";
					exit();
			       }
				   $have_fen=1;
				}
			}
	}
}
//验证码
$ip=egetip();
$pass=md5(ReturnDownSysCheckIp()."wm_chief".$public_r[downpass].$user[userid]);
$op=GetOnlinePass();
$url="../doaction.php?enews=GetSofturl&classid=$classid&id=$id&pathid=$pathid&pass=".$pass."&p=".$user[userid].":::".$user[rnd]."&onlinetime=".$op[0]."&onlinepass=".$op[1];
$trueurl=ReturnDSofturl($showdown_r[1],$showdown_r[4],'../../',0);//实际地址
$playerpass="wm_chief";
//自动识别播放器
if(empty($r[playerid]))
{
	$ftype=GetFiletype($showdown_r[1]);
	if($ftype=='.swf')
	{
		@include("flasher.php");
	}
	elseif($ftype=='.flv')
	{
		@include("flver.php");
	}
	elseif(strstr($ecms_config['sets']['realplayertype'],','.$ftype.','))
	{
		@include("realplayer.php");
	}
	else
	{
		@include("mediaplayer.php");
	}
}
else
{
	$playerr=$empire->fetch1("select filename from {$dbtbpre}enewsplayer where id='$r[playerid]'");
	if($playerr['filename'])
	{
		@include($playerr[filename]);
	}
}
db_close();
$empire=null;
?>