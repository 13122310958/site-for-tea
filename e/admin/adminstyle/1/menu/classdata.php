<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�˵�</title>
<link href="../../../data/menu/menu.css" rel="stylesheet" type="text/css">
<script src="../../../data/menu/menu.js" type="text/javascript"></script>
<SCRIPT lanuage="JScript">
function tourl(url){
	parent.main.location.href=url;
}
</SCRIPT>
</head>
<body onLoad="initialize()">
<table border='0' cellspacing='0' cellpadding='0'>
	<tr height=20>
			<td id="home"><img src="../../../data/images/homepage.gif" border=0></td>
			<td><b>��Ŀ����</b></td>
	</tr>
</table>

<table border='0' cellspacing='0' cellpadding='0'>
  <tr> 
    <td id="prcinfo" class="menu1" onclick="chengstate('cinfo')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��Ϣ��ع���</a>
	</td>
  </tr>
  <tr id="itemcinfo" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../ListAllInfo.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������Ϣ</a>
          </td>
        </tr>
        <tr> 
          <td class="file">
			<a href="../../ListAllInfo.php?ecmscheck=1" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Ϣ</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../workflow/ListWfInfo.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">ǩ����Ϣ</a>
          </td>
        </tr>
		<?
		if($r[dopl])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../openpage/AdminPage.php?leftfile=<?=urlencode('../pl/PlNav.php')?>&mainfile=<?=urlencode('../pl/PlMain.php')?>&title=<?=urlencode('��������')?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��������</a>
          </td>
        </tr>
		<?
		}
		?>
		<tr> 
          <td class="file">
			<a href="../../sp/UpdateSp.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������Ƭ</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../special/UpdateZt.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����ר��</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../info/InfoMain.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����ͳ��</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../infotop.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����ͳ��</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>

<?
if($r[doclass]||$r[dosetmclass]||$r[doclassf])
{
?>
  <tr> 
    <td id="prclassdata" class="menu1" onclick="chengstate('classdata')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��Ŀ����</a>
	</td>
  </tr>
  <tr id="itemclassdata" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<?
		if($r[doclass])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../ListClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������Ŀ</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../ListPageClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������Ŀ(��ҳ)</a>
          </td>
        </tr>
		<?
		}
		if($r[doclassf])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../info/ListClassF.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��Ŀ�Զ����ֶ�</a>
          </td>
        </tr>
		<?
		}
		if($r[dosetmclass])
		{
		?>
		<tr> 
          <td class="file1">
			<a href="../../SetMoreClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����������Ŀ����</a>
          </td>
        </tr>
		<?
		}
		?>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dozt]||$r[doztf])
{
?>
  <tr> 
    <td id="przt" class="menu1" onclick="chengstate('zt')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">ר�����</a>
	</td>
  </tr>
  <tr id="itemzt" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<?php
		if($r[dozt])
		{
		?>
        <tr> 
          <td class="file">
			<a href="../../special/ListZtClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����ר�����</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../special/ListZt.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����ר��</a>
          </td>
        </tr>
		<?php
		}
		if($r[doztf])
		{
		?>
		<tr> 
          <td class="file1">
			<a href="../../special/ListZtF.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">ר���Զ����ֶ�</a>
          </td>
        </tr>
		<?php
		}
		?>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[doinfotype])
{
?>
  <tr> 
    <td id="prinfotype" class="menu1" onclick="chengstate('infotype')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����������</a>
	</td>
  </tr>
  <tr id="iteminfotype" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../info/AddInfoType.php?enews=AddInfoType" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">���ӱ������</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../info/InfoType.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����������</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dosp])
{
?>
  <tr> 
    <td id="prsp" class="menu1" onclick="chengstate('sp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��Ƭ����</a>
	</td>
  </tr>
  <tr id="itemsp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../sp/ListSpClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������Ƭ����</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../sp/ListSp.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������Ƭ</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[douserpage])
{
?>
  <tr> 
    <td id="pruserpage" class="menu1" onclick="chengstate('userpage')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�Զ���ҳ��</a>
	</td>
  </tr>
  <tr id="itemuserpage" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/PageClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ���ҳ�����</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/AddPage.php?enews=AddUserpage" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ���ҳ��</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/ListPage.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ���ҳ��</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[douserlist])
{
?>
  <tr> 
    <td id="pruserlist" class="menu1" onclick="chengstate('userlist')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�Զ����б�</a>
	</td>
  </tr>
  <tr id="itemuserlist" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../other/UserlistClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ����б�����</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../other/AddUserlist.php?enews=AddUserlist" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ����б�</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../other/ListUserlist.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ����б�</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[douserjs])
{
?>
  <tr> 
    <td id="pruserjs" class="menu1" onclick="chengstate('userjs')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�Զ���JS</a>
	</td>
  </tr>
  <tr id="itemuserjs" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../other/UserjsClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ���JS����</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../other/AddUserjs.php?enews=AddUserjs" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ���JS</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../other/ListUserjs.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����Զ���JS</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotags])
{
?>
  <tr> 
    <td id="prtags" class="menu1" onclick="chengstate('tags')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">TAGS����</a>
	</td>
  </tr>
  <tr id="itemtags" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../tags/SetTags.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����TAGS����</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../tags/TagsClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����TAGS����</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../tags/ListTags.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����TAGS</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dofile])
{
?>
  <tr> 
    <td id="prfile" class="menu1" onclick="chengstate('file')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��������</a>
	</td>
  </tr>
  <tr id="itemfile" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file1">
			<a href="../../openpage/AdminPage.php?leftfile=<?=urlencode('../file/FileNav.php')?>&title=<?=urlencode('��������')?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��������</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[docj])
{
?>
  <tr> 
    <td id="prcj" class="menu1" onclick="chengstate('cj')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�ɼ�����</a>
	</td>
  </tr>
  <tr id="itemcj" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../AddInfoC.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">���Ӳɼ��ڵ�</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../ListInfoClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����ɼ��ڵ�</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../ListPageInfoClass.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����ɼ��ڵ�(��ҳ)</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dosearchall])
{
?>
  <tr> 
    <td id="prsearchall" class="menu1" onclick="chengstate('searchall')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">ȫվȫ������</a>
	</td>
  </tr>
  <tr id="itemsearchall" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../searchall/SetSearchAll.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">ȫվ��������</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../searchall/ListSearchLoadTb.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������������Դ</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../searchall/ClearSearchAll.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">������������</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dowap])
{
?>
  <tr> 
    <td id="prwap" class="menu1" onclick="chengstate('wap')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">WAP����</a>
	</td>
  </tr>
  <tr id="itemwap" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../other/SetWap.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">WAP����</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../other/WapStyle.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����WAPģ��</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[domovenews]||$r[doinfodoc]||$r[dodelinfodata]||$r[dorepnewstext]||$r[dototaldata]||$r[dosearchkey]||$r[dovotemod])
{
?>
  <tr> 
    <td id="prcother" class="menu3" onclick="chengstate('cother')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�������</a>
	</td>
  </tr>
  <tr id="itemcother" style="display:none"> 
    <td class="list1">
		<table border='0' cellspacing='0' cellpadding='0'>
		<?
		if($r[dototaldata])
		{
		?>
        <tr> 
          <td class="file">
			<a href="../../TotalData.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">ͳ����Ϣ����</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../user/UserTotal.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�û�����ͳ��</a>
          </td>
        </tr>
		<?
		}
		if($r[dosearchkey])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../SearchKey.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">���������ؼ���</a>
          </td>
        </tr>
		<?
		}
		if($r[dorepnewstext])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../db/RepNewstext.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">�����滻�ֶ�ֵ</a>
          </td>
        </tr>
		<?
		}
		if($r[domovenews])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../MoveClassNews.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����ת����Ϣ</a>
          </td>
        </tr>
		<?
		}
		if($r[doinfodoc])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../InfoDoc.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">��Ϣ�����鵵</a>
          </td>
        </tr>
		<?
		}
		if($r[dodelinfodata])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../db/DelData.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����ɾ����Ϣ</a>
          </td>
        </tr>
		<?
		}
		if($r[dovotemod])
		{
		?>
		<tr> 
          <td class="file1">
			<a href="../../other/ListVoteMod.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">����Ԥ��ͶƱ</a>
          </td>
        </tr>
		<?
		}
		?>
      </table>
	</td>
  </tr>
<?
}
?>
</table>
</body>
</html>