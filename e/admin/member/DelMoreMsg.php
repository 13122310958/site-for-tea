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
CheckLevel($logininid,$loginin,$classid,"msg");
$enews=$_POST['enews'];
if($enews=="DelMoreMsg")
{
	include("../../class/com_functions.php");
	DelMoreMsg($_POST,$logininid,$loginin);
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ɾ��վ�ڶ���Ϣ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ��: <a href="DelMoreMsg.php">����ɾ��վ�ڶ���Ϣ</a></td>
  </tr>
</table>
<form name="form1" method="post" action="DelMoreMsg.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">ɾ��վ�ڶ���Ϣ 
          <input name="enews" type="hidden" id="enews" value="DelMoreMsg">
        </div></td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">��Ϣ����</td>
      <td width="80%" bgcolor="#FFFFFF"><select name="msgtype" id="msgtype">
          <option value="0">ǰ̨ȫ����Ϣ</option>
		  <option value="2">ֻɾ��ǰ̨ϵͳ��Ϣ</option>
		  <option value="1">��̨ȫ����Ϣ</option>
		  <option value="3">ֻɾ����̨ϵͳ��Ϣ</option>
        </select></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">������</td>
      <td bgcolor="#FFFFFF"><input name="from_username" type="text" id="from_username">
        <input name="fromlike" type="checkbox" id="fromlike" value="1" checked>
        ģ��ƥ�� (����Ϊ����)</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">�ռ���</td>
      <td bgcolor="#FFFFFF"><input name="to_username" type="text" id="to_username">
        <input name="tolike" type="checkbox" id="tolike" value="1" checked>
        ģ��ƥ��(����Ϊ����)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�����ؼ���</td>
      <td bgcolor="#FFFFFF"><input name="keyboard" type="text" id="keyboard"> 
        <select name="keyfield" id="keyfield">
          <option value="0">�������������</option>
          <option value="1">������Ϣ����</option>
          <option value="2">������Ϣ����</option>
        </select>
        (�������&quot;,&quot;��)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ʱ��</td>
      <td bgcolor="#FFFFFF">ɾ���� 
        <input name="starttime" type="text" id="starttime" onclick="setday(this)" size="12">
        �� 
        <input name="endtime" type="text" id="endtime" onclick="setday(this)" size="12">
        ֮��Ķ���Ϣ</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="����ɾ��"></td>
    </tr>
  </table>
</form>
</body>
</html>