<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"votemod");

//����Ԥ��ͶƱ
function AddVoteMod($ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $empire,$dbtbpre;
	if(!$ysvotename||!$tempid)
	{
		printerror("EmptyVoteTitle","history.go(-1)");
	}
	//�������
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,0);
	//ͳ����Ʊ��
	for($i=0;$i<count($votename);$i++)
	{
		$t_votenum+=$votenum[$i];
	}
	$dotime=date("Y-m-d");
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$sql=$empire->query("insert into {$dbtbpre}enewsvotemod(title,votetext,voteclass,doip,dotime,tempid,width,height,votenum,ysvotename) values('$title','$votetext',$voteclass,$doip,'$dotime',$tempid,$width,$height,$t_votenum,'$ysvotename');");
	$voteid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("AddVoteSuccess","AddVoteMod.php?enews=AddVoteMod");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸�Ԥ��ͶƱ
function EditVoteMod($voteid,$ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $empire,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid||!$ysvotename||!$tempid)
	{
		printerror("EmptyVoteTitle","history.go(-1)");
	}
	//�������
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,1);
	//ͳ����Ʊ��
	for($i=0;$i<count($votename);$i++)
	{
		$t_votenum+=$votenum[$i];
	}
	//��������
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$sql=$empire->query("update {$dbtbpre}enewsvotemod set title='$title',votetext='$votetext',voteclass=$voteclass,doip=$doip,dotime='$dotime',tempid=$tempid,width=$width,height=$height,votenum=$t_votenum,ysvotename='$ysvotename' where voteid='$voteid'");
	if($sql)
	{
		//������־
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("EditVoteSuccess","ListVoteMod.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ��Ԥ��ͶƱ
function DelVoteMod($voteid,$userid,$username){
	global $empire,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid)
	{
		printerror("NotDelVoteid","history.go(-1)");
	}
	$r=$empire->fetch1("select title from {$dbtbpre}enewsvotemod where voteid='$voteid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsvotemod where voteid='$voteid'");
	if($sql)
	{
		//������־
		insert_dolog("voteid=".$voteid."<br>title=".$r[title]);
		printerror("DelVoteSuccess","ListVoteMod.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}


$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
//����ͶƱ
if($enews=="AddVoteMod")
{
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	$ysvotename=$_POST['ysvotename'];
	AddVoteMod($ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//�޸�ͶƱ
elseif($enews=="EditVoteMod")
{
	$voteid=$_POST['voteid'];
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	$ysvotename=$_POST['ysvotename'];
	EditVoteMod($voteid,$ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//ɾ��ͶƱ
elseif($enews=="DelVoteMod")
{
	$voteid=$_GET['voteid'];
	DelVoteMod($voteid,$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select voteid,ysvotename,title,voteclass from {$dbtbpre}enewsvotemod";
$num=$empire->num($query);//ȡ��������
$query=$query." order by voteid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListVoteMod.php>����Ԥ��ͶƱ</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ͶƱ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="����Ԥ��ͶƱ" onclick="self.location.href='AddVoteMod.php?enews=AddVoteMod';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="10%" height="25"><div align="center">ID</div></td>
    <td width="43%" height="25"><div align="center">ͶƱ����</div></td>
    <td width="18%" height="25"><div align="center">����</div></td>
    <td width="29%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$voteclass=empty($r['voteclass'])?'��ѡ':'��ѡ';
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"> 
        <?=$r[voteid]?>
      </div></td>
    <td height="25"> 
      <?=$r[ysvotename]?>
    </td>
    <td height="25"><div align="center"> 
        <?=$voteclass?>
      </div></td>
    <td height="25"><div align="center">[<a href="AddVoteMod.php?enews=EditVoteMod&voteid=<?=$r[voteid]?>">�޸�</a>] 
        [<a href="ListVoteMod.php?enews=DelVoteMod&voteid=<?=$r[voteid]?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="4">&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>