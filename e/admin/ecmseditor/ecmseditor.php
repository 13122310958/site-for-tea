<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
require "../".LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
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
$addgethtmlpath="../";
if($public_r['phpmode'])
{
	include("../../class/ftp.php");
	$incftp=1;
}
require("editorfun.php");
$doetran=1;
if($enews=="TranFile")//上传文件
{
	$file=$_FILES['file']['tmp_name'];
	$file_name=$_FILES['file']['name'];
	$file_type=$_FILES['file']['type'];
	$file_size=$_FILES['file']['size'];
	$tranurl=$_POST['tranurl'];
	$no=$_POST['no'];
	$classid=$_POST['classid'];
	$type=$_POST['type'];
	TranFile($file,$file_name,$file_type,$file_size,$tranurl,$no,$classid,$type,$_POST,$logininid,$loginin);
}
elseif($enews=="SaveMoreImg")//批量上传图片
{
	$file=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
	eTranMorePic($file,$file_name,$file_type,$file_size,$_POST,$logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>