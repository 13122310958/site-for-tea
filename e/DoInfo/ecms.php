<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/delpath.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
require("../member/class/user.php");
require("../class/qinfofun.php");
$link=db_connect();
$empire=new mysqlquery();
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
//验证IP
eCheckAccessDoIp('postinfo');
$muserid=(int)getcvar('mluserid');
$musername=RepPostVar(getcvar('mlusername'));
$mrnd=RepPostVar(getcvar('mlrnd'));
$loginin='[Member]'.$musername;
$doetran=1;
//增加投稿
if($enews=="MAddInfo")
{
	DodoInfo($_POST,0);
}
//修改投稿
elseif($enews=="MEditInfo")
{
	DodoInfo($_POST,1);
}
//删除投稿
elseif($enews=="MDelInfo")
{
	DodoInfo($_GET,2);
}
//编辑器上传图片
elseif($enews=="MEditorTranFile")
{
	$file=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
	DoQTranFile($_POST,$file,$file_name,$file_type,$file_size,$muserid,$musername,$mrnd,1);
}
//上传附件
elseif($enews=="MTranFile")
{
	$file=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
	DoQTranFile($_POST,$file,$file_name,$file_type,$file_size,$muserid,$musername,$mrnd,0);
}
else
{printerror("ErrorUrl","",1);}
db_close();
$empire=null;
?>