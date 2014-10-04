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
CheckLevel($logininid,$loginin,$classid,"workflow");

//���ӹ�����
function AddWorkflow($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[wfname])
	{
		printerror('EmptyWorkflow','history.go(-1)');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"workflow");
	$add[myorder]=(int)$add[myorder];
	$addtime=time();
	$sql=$empire->query("insert into {$dbtbpre}enewsworkflow(wfname,wftext,myorder,addtime,adduser) values('$add[wfname]','$add[wftext]','$add[myorder]','$addtime','$username');");
	$wfid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("wfid=".$wfid."<br>wfname=".$add[wfname]);
		printerror("AddWorkflowSuccess","AddWf.php?enews=AddWorkflow");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ĺ�����
function EditWorkflow($add,$userid,$username){
	global $empire,$dbtbpre;
	$wfid=(int)$add[wfid];
	if(!$wfid||!$add[wfname])
	{
		printerror('EmptyWorkflow','history.go(-1)');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"workflow");
	$add[myorder]=(int)$add[myorder];
	$sql=$empire->query("update {$dbtbpre}enewsworkflow set wfname='$add[wfname]',wftext='$add[wftext]',myorder='$add[myorder]' where wfid='$wfid'");
	if($sql)
	{
		//������־
		insert_dolog("wfid=".$wfid."<br>wfname=".$add[wfname]);
		printerror("EditWorkflowSuccess","ListWf.php");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ��������
function DelWorkflow($add,$userid,$username){
	global $empire,$dbtbpre;
	$wfid=(int)$add[wfid];
	if(!$wfid)
	{
		printerror('NotDelWorkflowid','history.go(-1)');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"workflow");
	$r=$empire->fetch1("select wfname from {$dbtbpre}enewsworkflow where wfid='$wfid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsworkflow where wfid='$wfid'");
	$sql2=$empire->query("delete from {$dbtbpre}enewsworkflowitem where wfid='$wfid'");
	if($sql&&$sql2)
	{
		//������־
		insert_dolog("wfid=".$wfid."<br>wfname=".$r[wfname]);
		printerror("DelWorkflowSuccess","ListWf.php");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews=="AddWorkflow")//���ӹ�����
{
	AddWorkflow($_POST,$logininid,$loginin);
}
elseif($enews=="EditWorkflow")//�޸Ĺ�����
{
	EditWorkflow($_POST,$logininid,$loginin);
}
elseif($enews=="DelWorkflow")//ɾ��������
{
	DelWorkflow($_GET,$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select wfid,wfname,addtime,adduser from {$dbtbpre}enewsworkflow";
$totalquery="select count(*) as total from {$dbtbpre}enewsworkflow";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by myorder,wfid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListWf.php>����������</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӹ�����" onclick="self.location.href='AddWf.php?enews=AddWorkflow';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="36%" height="25"> <div align="center">����������</div></td>
    <td width="14%"><div align="center">������</div></td>
    <td width="19%"> <div align="center">����ʱ��</div></td>
    <td width="13%"><div align="center">���̽ڵ�</div></td>
    <td width="13%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"> 
        <?=$r[wfid]?>
      </div></td>
    <td height="25"> 
      <?=$r[wfname]?>
      </td>
    <td><div align="center">
        <?=$r[adduser]?>
      </div></td>
    <td><div align="center">
        <?=date('Y-m-d H:i:s',$r[addtime])?>
        </div></td>
    <td> <div align="center"><a href="ListWfItem.php?wfid=<?=$r[wfid]?>">�����ڵ�</a></div>
      <div align="center"></div></td>
    <td height="25"><div align="center">[<a href="AddWf.php?enews=EditWorkflow&wfid=<?=$r[wfid]?>">�޸�</a>] 
        [<a href="ListWf.php?enews=DelWorkflow&wfid=<?=$r[wfid]?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6">&nbsp; 
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