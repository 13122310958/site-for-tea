<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/delpath.php");
require("../class/copypath.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
$link=db_connect();
$empire=new mysqlquery();
$enews=$_POST['enews'];
if(empty($enews))
{
	$enews=$_GET['enews'];
}
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
$incftp=0;
if($public_r['phpmode'])
{
	include("../class/ftp.php");
	$incftp=1;
}
//���ɼ�
if($public_r['opennotcj'])
{
	@include("../data/dbcache/notcj.php");
}
//��Ա
require("../member/class/user.php");
require("../class/hinfofun.php");
if($enews=="AddNews")//������Ϣ
{
	$navtheid=(int)$_POST['filepass'];
	AddNews($_POST,$logininid,$loginin);
}
elseif($enews=="EditNews")//�޸���Ϣ
{
	$navtheid=(int)$_POST['id'];
	EditNews($_POST,$logininid,$loginin);
}
elseif($enews=="EditInfoSimple")//�޸���Ϣ(����)
{
	$navtheid=(int)$_POST['id'];
	EditInfoSimple($_POST,$logininid,$loginin);
}
elseif($enews=="DelNews")//ɾ����Ϣ
{
	$id=$_GET['id'];
	$classid=$_GET['classid'];
	$bclassid=$_GET['bclassid'];
	DelNews($id,$classid,$logininid,$loginin);
}
elseif($enews=="DelNews_all")//����ɾ����Ϣ
{
	$id=$_POST['id'];
	$classid=$_POST['classid'];
	$bclassid=$_POST['bclassid'];
	$ecms=$_POST['ecmscheck']?2:0;
	DelNews_all($id,$classid,$logininid,$loginin,$ecms);
}
elseif($enews=="EditMoreInfoTime")//�����޸���Ϣʱ��
{
	EditMoreInfoTime($_POST,$logininid,$loginin);
}
elseif($enews=="DelInfoDoc_all")//ɾ���鵵
{
	$id=$_POST['id'];
	$classid=$_POST['classid'];
	$bclassid=$_POST['bclassid'];
	DelNews_all($id,$classid,$logininid,$loginin,1);
}
elseif($enews=='AddInfoToReHtml')//ˢ��ҳ��
{
	AddInfoToReHtml($_GET['classid'],$_GET['dore']);
}
elseif($enews=="TopNews_all")//��Ϣ�ö�
{
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	$id=$_POST['id'];
	$istop=$_POST['istop'];
	TopNews_all($classid,$id,$istop,$logininid,$loginin);
}
elseif($enews=="CheckNews_all")//�����Ϣ
{
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	$id=$_POST['id'];
	CheckNews_all($classid,$id,$logininid,$loginin);
}
elseif($enews=="NoCheckNews_all")//ȡ�������Ϣ
{
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	$id=$_POST['id'];
	NoCheckNews_all($classid,$id,$logininid,$loginin);
}
elseif($enews=="MoveNews_all")//�ƶ���Ϣ
{
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	$id=$_POST['id'];
	$to_classid=$_POST['to_classid'];
	MoveNews_all($classid,$id,$to_classid,$logininid,$loginin);
}
elseif($enews=="CopyNews_all")//������Ϣ
{
	$bclassid=$_POST['bclassid'];
	$classid=$_POST['classid'];
	$id=$_POST['id'];
	$to_classid=$_POST['to_classid'];
	CopyNews_all($classid,$id,$to_classid,$logininid,$loginin);
}
elseif($enews=="MoveClassNews")//�����ƶ���Ϣ
{
	$add=$_POST['add'];
	MoveClassNews($add,$logininid,$loginin);
}
elseif($enews=="GoodInfo_all")//�����Ƽ�/ͷ����Ϣ
{
	$classid=$_POST['classid'];
	$id=$_POST['id'];
	$doing=$_POST['doing'];
	$isgood=empty($doing)?$_POST['isgood']:$_POST['firsttitle'];
	GoodInfo_all($classid,$id,$isgood,$doing,$logininid,$loginin);
}
elseif($enews=="SetAllCheckInfo")//����Ŀ��Ϣȫ�����
{
	$classid=$_GET['classid'];
	$bclassid=$_GET['bclassid'];
	SetAllCheckInfo($bclassid,$classid,$logininid,$loginin);
}
elseif($enews=="DoWfInfo")//ǩ����Ϣ
{
	DoWfInfo($_POST,$logininid,$loginin);
}
elseif($enews=="DelInfoData")//ɾ����Ϣҳ��
{
	$start=$_GET['start'];
	$classid=$_GET['classid'];
	$from=$_GET['from'];
	$retype=$_GET['retype'];
	$startday=$_GET['startday'];
	$endday=$_GET['endday'];
	$startid=$_GET['startid'];
	$endid=$_GET['endid'];
	$tbname=$_GET['tbname'];
	DelInfoData($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$_GET,$logininid,$loginin);
}
elseif($enews=="InfoToDoc")//�鵵��Ϣ
{
	if($_GET['ecmsdoc']==1)//��Ŀ
	{
		InfoToDoc_class($_GET,$logininid,$loginin);
	}
	elseif($_GET['ecmsdoc']==2)//����
	{
		InfoToDoc($_GET,$logininid,$loginin);
	}
	else//��Ϣ
	{
		InfoToDoc_info($_POST,$logininid,$loginin);
	}
}
elseif($enews=="DoInfoAndSendNotice")//������Ϣ��֪ͨ
{
	$doing=(int)$_POST['doing'];
	$adddatar=$_POST;
	if($doing==1)//ɾ��
	{
		$enews='DelNews';
		DelNews($adddatar['id'],$adddatar['classid'],$logininid,$loginin);
	}
	elseif($doing==2)//���ͨ��
	{
		$enews='CheckNews_all';
		$doid[0]=$adddatar['id'];
		CheckNews_all($adddatar['classid'],$doid,$logininid,$loginin);
	}
	elseif($doing==3)//ȡ�����
	{
		$enews='NoCheckNews_all';
		$doid[0]=$adddatar['id'];
		NoCheckNews_all($adddatar['classid'],$doid,$logininid,$loginin);
	}
	elseif($doing==4)//ת��
	{
		$enews='MoveNews_all';
		$doid[0]=$adddatar['id'];
		MoveNews_all($adddatar['classid'],$doid,$adddatar['to_classid'],$logininid,$loginin);
	}
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>