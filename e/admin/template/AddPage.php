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
CheckLevel($logininid,$loginin,$classid,"userpage");
$gid=(int)$_GET['gid'];
if(!$gid)
{
	$gid=GetDoTempGid();
}
$cid=$_GET['cid'];
$enews=$_GET['enews'];
$r[path]='../../page.html';
$r['tempid']=0;
$url="<a href=ListPage.php>�����Զ���ҳ��</a>&nbsp;>&nbsp;�����Զ���ҳ��";
//����
if($enews=="AddUserpage"&&$_GET['docopy'])
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select id,title,path,pagetext,classid,pagetitle,pagekeywords,pagedescription,tempid from {$dbtbpre}enewspage where id='$id'");
	$url="<a href=ListPage.php>�����Զ���ҳ��</a>&nbsp;>&nbsp;�����Զ���ҳ�棺<b>".$r[title]."</b>";
}
//�޸�
if($enews=="EditUserpage")
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select id,title,path,pagetext,classid,pagetitle,pagekeywords,pagedescription,tempid from {$dbtbpre}enewspage where id='$id'");
	$url="<a href=ListPage.php>�����Զ���ҳ��</a>&nbsp;>&nbsp;�޸��Զ���ҳ�棺<b>".$r[title]."</b>";
}
//ģʽ
$pagemod=1;
if($r['tempid'])
{
	$pagemod=2;
}
if($_GET['ChangePagemod'])
{
	$pagemod=(int)$_GET['ChangePagemod'];
}
//����
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewspageclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
if($pagemod==2)
{
//ģ��
$pagetempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewspagetemp")." order by tempid");
while($pagetempr=$empire->fetch($pagetempsql))
{
	$select="";
	if($r[tempid]==$pagetempr[tempid])
	{
		$select=" selected";
	}
	$pagetemp.="<option value='".$pagetempr[tempid]."'".$select.">".$pagetempr[tempname]."</option>";
}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����û��Զ���ҳ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ReturnHtml(html)
{
document.form1.pagetext.value=html;
}
</script>
<SCRIPT lanuage="JScript">
<!--
function tempturnit(ss)
{
 if (ss.style.display=="") 
  ss.style.display="none";
 else
  ss.style.display=""; 
}
-->
</SCRIPT>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="../ecmscom.php">
    <tr class="header"> 
      <td height="25" colspan="2">�����û��Զ���ҳ�� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="id" type="hidden" id="id" value="<?=$id?>"> 
        <input name="oldpath" type="hidden" id="oldpath" value="<?=$r[path]?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="gid" type="hidden" id="gid" value="<?=$gid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ҳ��ģʽ��</td>
      <td height="25"><input type="radio" name="pagemod" value="1" onclick="self.location.href='AddPage.php?enews=<?=$enews?>&id=<?=$id?>&cid=<?=$cid?>&docopy=<?=$_GET['docopy']?>&gid=<?=$gid?>&ChangePagemod=1';"<?=$pagemod==1?' checked':''?>>
        ֱ��ҳ��ʽ 
        <input type="radio" name="pagemod" value="2" onclick="self.location.href='AddPage.php?enews=<?=$enews?>&id=<?=$id?>&cid=<?=$cid?>&docopy=<?=$_GET['docopy']?>&gid=<?=$gid?>&ChangePagemod=2';"<?=$pagemod==2?' checked':''?>>
        ����ģ��ʽ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">ҳ������(*)</td>
      <td width="81%" height="25"> <input name="title" type="text" id="title" value="<?=$r[title]?>" size="42"> 
        <font color="#666666">(�磺��ϵ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�ļ���(*)</td>
      <td height="25"><input name="path" type="text" id="path" value="<?=$r[path]?>" size="42"> 
        <input type="button" name="Submit4" value="ѡ��Ŀ¼" onclick="window.open('../file/ChangePath.php?returnform=opener.document.form1.path.value','','width=400,height=500,scrollbars=yes');"> 
        <font color="#666666">(�磺../../about.html�����ڸ�Ŀ¼)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������</td>
      <td height="25"><select name="classid" id="classid">
          <option value="0">���������κ����</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="��������" onclick="window.open('PageClass.php');"></td>
    </tr>
	<?php
	if($pagemod==2)
	{
	?>
    <tr bgcolor="#FFFFFF">
      <td height="25">ʹ�õ�ģ��</td>
      <td height="25"><select name="tempid" id="tempid">
          <?=$pagetemp?>
        </select> 
        <input type="button" name="Submit62223" value="�����Զ���ҳ��ģ��" onclick="window.open('../template/ListPagetemp.php?gid=<?=$gid?>');"></td>
    </tr>
	<?php
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ҳ����</td>
      <td height="25"><input name="pagetitle" type="text" id="pagetitle" value="<?=ehtmlspecialchars(stripSlashes($r[pagetitle]))?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ҳ�ؼ���</td>
      <td height="25"><input name="pagekeywords" type="text" id="pagekeywords" value="<?=ehtmlspecialchars(stripSlashes($r[pagekeywords]))?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ҳ����</td>
      <td height="25"><input name="pagedescription" type="text" id="pagedescription" value="<?=ehtmlspecialchars(stripSlashes($r[pagedescription]))?>" size="42"></td>
    </tr>
	<?php
	if($pagemod==2)
	{
		//--------------------html�༭��
		include('../ecmseditor/infoeditor/fckeditor.php');
	?>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"><strong>ҳ������</strong>(*)</td>
      <td height="25"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top"> 
        <?=ECMS_ShowEditorVar('pagetext',stripSlashes($r[pagetext]),'Default','../ecmseditor/infoeditor/','300','100%')?>
      </td>
    </tr>
	<?php
	}
	else
	{
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"><strong>ҳ������</strong>(*)</td>
      <td height="25">�뽫ҳ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.pagetext.value);document.form1.pagetext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.pagetext.value&returnvar=opener.document.form1.pagetext.value&fun=ReturnHtml','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top"><div align="center"> 
          <textarea name="pagetext" cols="90" rows="27" id="pagetext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[pagetext]))?></textarea>
        </div></td>
    </tr>
	<?php
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
	</form>
	<?php
	if($pagemod!=2)
	{
	?>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php','','width=600,height=500,scrollbars=yes,resizable=yes');">�鿴ģ���ǩ�﷨</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴��ǩģ��</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield" type="text" value="[!--pagetitle--]">
              : ��ҳ����</td>
            <td width="34%"><input name="textfield2" type="text" value="[!--pagekeywords--]">
              : ��ҳ�ؼ���</td>
            <td width="33%"><input name="textfield3" type="text" value="[!--pagedescription--]">
              : ��ҳ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield322" type="text" value="[!--pagename--]">
              : ҳ������</td>
            <td><input name="textfield3222" type="text" value="[!--pageid--]">
              : ҳ��ID</td>
            <td><input name="textfield4" type="text" value="[!--news.url--]">
              : ��վ��ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>֧�ֹ���ģ�����</strong></td>
            <td><strong>֧������ģ���ǩ</strong></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
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