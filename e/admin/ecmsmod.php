<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../data/dbcache/class.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
$enews=$_POST['enews'];
if(empty($enews))
{
	$enews=$_GET['enews'];
}
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
require("../class/moddofun.php");
//增加字段
if($enews=="AddF")
{
	$add=$_POST;
	AddF($add,$logininid,$loginin);
}
//修改字段
elseif($enews=="EditF")
{
	$add=$_POST;
	EditF($add,$logininid,$loginin);
}
//修改系统字段
elseif($enews=="EditSysF")
{
	EditSysF($_POST,$logininid,$loginin);
}
//删除字段
elseif($enews=="DelF")
{
	$fid=$_GET['fid'];
	$tid=$_GET['tid'];
	$tbname=$_GET['tbname'];
	DelF($fid,$tid,$tbname,$logininid,$loginin);
}
//修改字段顺序
elseif($enews=="EditFOrder")
{
	$fid=$_POST['fid'];
	$tid=$_POST['tid'];
	$tbname=$_POST['tbname'];
	$myorder=$_POST['myorder'];
	EditFOrder($fid,$myorder,$tid,$tbname,$logininid,$loginin);
}
elseif($enews=='ChangeDataTableF')//转移字段
{
	ChangeDataTableF($_GET,$logininid,$loginin);
}
elseif($enews=='ChangeDocDataTableF')//转移字段(归档)
{
	ChangeDocDataTableF($_GET,$logininid,$loginin);
}
//增加模型
elseif($enews=="AddM")
{
	$add=$_POST['add'];
	$cname=$_POST['cname'];
	$cchange=$_POST['cchange'];
	$schange=$_POST['schange'];
	$center=$_POST['center'];
	$cqenter=$_POST['cqenter'];
	$menter=$_POST['menter'];
	AddM($add,$cname,$cchange,$schange,$center,$cqenter,$menter,$_POST['listand'],$_POST['ltempf'],$_POST['ptempf'],$_POST['canadd'],$_POST['canedit'],$_POST['listorder'],$logininid,$loginin);
}
//修改模型
elseif($enews=="EditM")
{
	$add=$_POST['add'];
	$cname=$_POST['cname'];
	$cchange=$_POST['cchange'];
	$schange=$_POST['schange'];
	$center=$_POST['center'];
	$cqenter=$_POST['cqenter'];
	$menter=$_POST['menter'];
	EditM($add,$cname,$cchange,$schange,$center,$cqenter,$menter,$_POST['listand'],$_POST['ltempf'],$_POST['ptempf'],$_POST['canadd'],$_POST['canedit'],$_POST['listorder'],$logininid,$loginin);
}
//删除模型
elseif($enews=="DelM")
{
	$mid=$_GET['mid'];
	$tid=$_GET['tid'];
	$tbname=$_GET['tbname'];
	DelM($mid,$tid,$tbname,$logininid,$loginin);
}
//默认模型
elseif($enews=="DefM")
{
	$mid=$_GET['mid'];
	$tid=$_GET['tid'];
	$tbname=$_GET['tbname'];
	DefM($mid,$tid,$tbname,$logininid,$loginin);
}
//新建数据表
elseif($enews=="AddTable")
{
	AddTable($_POST,$logininid,$loginin);
}
//复制数据表
elseif($enews=="CopyNewTable")
{
	CopyNewTable($_POST,$logininid,$loginin);
}
//修改数据表
elseif($enews=="EditTable")
{
	EditTable($_POST,$logininid,$loginin);
}
//删除数据表
elseif($enews=="DelTable")
{
	$tid=$_GET['tid'];
	DelTable($tid,$logininid,$loginin);
}
//默认数据表
elseif($enews=="DefaultTable")
{
	$tid=$_GET['tid'];
	DefaultTable($tid,$logininid,$loginin);
}
elseif($enews=="AddDataTable")//增加副表分表
{
	AddDataTable($_POST,$logininid,$loginin);
}
elseif($enews=="DefDataTable")//默认副表分表
{
	DefDataTable($_GET,$logininid,$loginin);
}
elseif($enews=="DelDataTable")//删除副表分表
{
	DelDataTable($_GET,$logininid,$loginin);
}
//导入模型
elseif($enews=="LoadInMod")
{
	$file=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
	LoadInMod($_POST,$file,$file_name,$file_type,$file_size,$logininid,$loginin);
}
elseif($enews=='ChangeAllModForm')//批量更新模型表单
{
	ChangeAllModForm($_GET,$logininid,$loginin);
}
else
{printerror("ErrorUrl","history.go(-1)");}
db_close();
$empire=null;
?>