<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
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
CheckLevel($logininid,$loginin,$classid,"totaldata");
$tbname=RepPostVar($_GET['tbname']);
if(empty($tbname))
{
	$tbname=$public_r['tbname'];
}
//���ݱ�
$b=0;
$htb=0;
$tbsql=$empire->query("select tbname,tname from {$dbtbpre}enewstable order by tid");
while($tbr=$empire->fetch($tbsql))
{
	$b=1;
	$select="";
	if($tbr[tbname]==$tbname)
	{
		$htb=1;
		$select=" selected";
	}
	$tbstr.="<option value='".$tbr[tbname]."'".$select.">".$tbr[tname]."</option>";
}
if($b==0)
{
	printerror('ErrorUrl','');
}
if($htb==0)
{
	printerror('ErrorUrl','');
}
//�û�
$sql=$empire->query("select userid,username from {$dbtbpre}enewsuser order by userid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�û�����ͳ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td height="25">λ�ã�<a href="UserTotal.php">�û�����ͳ��</a></td>
  </tr>
  <tr>
    <td height="30"> ѡ��ͳ�����ݱ��� 
      <select name="tbname" id="tbname" onchange="window.location='UserTotal.php?tbname='+this.options[this.selectedIndex].value">
	  <?=$tbstr?>
      </select>
    </td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="25%" height="25"> 
      <div align="center">�û�</div></td>
    <td width="13%" height="25"> <div align="center">���췢����</div></td>
    <td width="13%" height="25"> <p align="center">���췢����</p></td>
    <td width="13%" height="25"> <div align="center">���·�����</div></td>
    <td width="13%"> <div align="center">�ܷ�����</div></td>
    <td width="13%"> 
      <div align="center">δ�����</div></td>
    <td width="10%"><div align="center"></div></td>
  </tr>
  <?php
  $totime=time();
  $today=date("Y-m-d");
  $yesterday=date("Y-m-d",$totime-24*3600);
  $month=date("Y-m");
  //�����������
  $maxday=date("t",mktime(0,0,0,date("m"),date("d"),date("Y")));
  while($r=$empire->fetch($sql))
  {
  	$tquery="select count(*) as total from {$dbtbpre}ecms_".$tbname." where userid='$r[userid]' and ismember=0";
	$checktquery="select count(*) as total from {$dbtbpre}ecms_".$tbname."_check where userid='$r[userid]' and ismember=0";
  	//���췢����
  	$todaynum=$empire->gettotal($tquery." and truetime>=".to_time($today." 00:00:00")." and truetime<=".to_time($today." 23:59:59"));
	$todaychecknum=$empire->gettotal($checktquery." and truetime>=".to_time($today." 00:00:00")." and truetime<=".to_time($today." 23:59:59"));
	//���췢����
	$yesterdaynum=$empire->gettotal($tquery." and truetime>=".to_time($yesterday." 00:00:00")." and truetime<=".to_time($yesterday." 23:59:59"));
	$yesterdaychecknum=$empire->gettotal($checktquery." and truetime>=".to_time($yesterday." 00:00:00")." and truetime<=".to_time($yesterday." 23:59:59"));
	//���·�����
	$monthnum=$empire->gettotal($tquery." and truetime>=".to_time($month."-01 00:00:00")." and truetime<=".to_time($month."-".$maxday." 23:59:59"));
	$monthchecknum=$empire->gettotal($checktquery." and truetime>=".to_time($month."-01 00:00:00")." and truetime<=".to_time($month."-".$maxday." 23:59:59"));
	//����
	$totalnum=$empire->gettotal($tquery);
	$checktotalnum=$empire->gettotal($checktquery);
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"><a href="AddUser.php?enews=EditUser&userid=<?=$r[userid]?>" target="_blank">
        <u><?=$r[username]?></u>
        </a></div></td>
    <td height="25"><div align="center"> 
        <?=$todaynum+$todaychecknum?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$yesterdaynum+$yesterdaychecknum?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$monthnum+$monthchecknum?>
      </div></td>
    <td><div align="center"><a href="../ListAllInfo.php?keyboard=<?=$r[username]?>&show=2&tbname=<?=$tbname?>&sear=1" target="_blank">
        <u><?=$totalnum+$checktotalnum?></u>
        </a> </div></td>
    <td><div align="center"><a href="../ListAllInfo.php?showspecial=4&keyboard=<?=$r[username]?>&show=2&tbname=<?=$tbname?>&sear=1&infocheck=2" target="_blank">
        <u><?=$nochecktotalnum?></u>
        </a></div></td>
    <td><div align="center"><a href="#ecms" onclick="window.open('MoreUserTotal.php?tbname=<?=$tbname?>&userid=<?=$r[userid]?>&username=<?=$r[username]?>','ViewUserTotal','width=420,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">[��ϸ]</a></div></td>
  </tr>
  <?php
  }
  ?>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>