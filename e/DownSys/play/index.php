<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../../data/dbcache/class.php");
require("../../data/dbcache/MemberLevel.php");
require("../class/DownSysFun.php");
eCheckCloseMods('movie');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$ecmsreurl=2;
//��֤IP
eCheckAccessDoIp('onlineinfo');
$id=(int)$_GET['id'];
$pathid=(int)$_GET['pathid'];
$classid=(int)$_GET['classid'];

//�۵㺯��
function ViewOnlineKFen($showdown_r,$u,$userid,$classid,$id,$pathid,$r){
	global $level_r,$class_r,$dbtbpre,$public_r,$empire,$have_bak,$have_fen;
	if($showdown_r[2])
	{
		//���ش�������
		$setuserday="";
		if($level_r[$u['groupid']][daydown])
		{
			$setuserday=DoCheckMDownNum($userid,$u['groupid'],1);
		}
		//�����Ƿ��㹻
		$showdown_r[3]=intval($showdown_r[3]);
		if($showdown_r[3])
		{
			if($have_fen==1)
			{
				//ȥ������
				$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userfen')."=".egetmf('userfen')."-".$showdown_r[3]." where ".egetmf('userid')."='$userid'");
			}
			if($have_bak==0)
			{
				//�������ؼ�¼
				$utfusername=$u['username'];
				BakDown($classid,$id,$pathid,$userid,$utfusername,$r[title],$showdown_r[3],1);
			}
		}
		//�����û����ش���
		if($setuserday)
		{
			$usql=$empire->query($setuserday);
		}
	}
	//������������һ
    $usql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]." set totaldown=totaldown+1 where id='$id'");
}

/*
��Դʶ��
if(!strstr($_SERVER['HTTP_REFERER'],$public_r[newsurl]))
{
	exit();
}
*/
if(!$classid||empty($class_r[$classid][tbname])||!$id)
{
	echo"<script>alert('��ӰƬ������');window.close();</script>";
	exit();
}
$mid=$class_r[$classid][modid];
$tbname=$class_r[$classid][tbname];
$query="select * from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1";
$r=$empire->fetch1($query);
if(!$r['id']||$r['classid']!=$classid)
{
	echo"<script>alert('��ӰƬ������');window.close();</script>";
	exit();
}
//����
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
//�������ص�ַ
$path_r=explode("\r\n",$r[onlinepath]);
if(!$path_r[$pathid])
{
	echo"<script>alert('��ӰƬ������');window.close();</script>";
	exit();
}
$showdown_r=explode("::::::",$path_r[$pathid]);
//����Ȩ��
$u=array();
$downgroup=$showdown_r[2];
if($downgroup)
{
	$user=islogin();
	//ȡ�û�Ա����
	$u=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$user[userid]' and ".egetmf('rnd')."='$user[rnd]' limit 1");
	if(empty($u['userid']))
	{
		echo"<script>alert('ͬһ�ʺţ�ֻ��һ������');window.close();</script>";
        exit();
    }
	//���ش�������
	if($level_r[$u['groupid']][daydown])
	{
		$setuserday=DoCheckMDownNum($user[userid],$u['groupid'],2);
		if($setuserday=='error')
		{
			echo"<script>alert('����������ۿ������ѳ���ϵͳ����(".$level_r[$u['groupid']][daydown]." ��)!');window.close();</script>";
			exit();
		}
	}
	if($level_r[$downgroup][level]>$level_r[$u['groupid']][level])
	{
		echo"<script>alert('���Ļ�Ա������(".$level_r[$downgroup][groupname].")��û�йۿ���ӰƬ��Ȩ��!');window.close();</script>";
            exit();
	}
	//�����Ƿ��㹻
	$have_bak=0;
	$have_fen=0;
	if($showdown_r[3])
	{
		//---------�Ƿ�����ʷ��¼
			$bakr=$empire->fetch1("select id,truetime from {$dbtbpre}enewsdownrecord where id='$id' and classid='$classid' and userid='$user[userid]' and pathid='$pathid' and online=1 order by truetime desc limit 1");
			if($bakr[id]&&(time()-$bakr[truetime]<=$public_r[redodown]*3600))
			{
				$have_bak=1;
			}
			else
			{
				//���¿�
				if($u['userdate']-time()>0)
				{}
				//����
				else
				{
			       if($showdown_r[3]>$u['userfen'])
			       {
					echo"<script>alert('���ĵ������� $showdown_r[3] �㣬�޷��ۿ���ӰƬ');window.close();</script>";
					exit();
			       }
				   $have_fen=1;
				}
			}
	}
}
//��֤��
$ip=egetip();
$pass=md5(ReturnDownSysCheckIp()."wm_chief".$public_r[downpass].$user[userid]);
$op=GetOnlinePass();
$url="../doaction.php?enews=GetSofturl&classid=$classid&id=$id&pathid=$pathid&pass=".$pass."&p=".$user[userid].":::".$user[rnd]."&onlinetime=".$op[0]."&onlinepass=".$op[1];
$trueurl=ReturnDSofturl($showdown_r[1],$showdown_r[4],'../../',0);//ʵ�ʵ�ַ
$playerpass="wm_chief";
//�Զ�ʶ�𲥷���
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