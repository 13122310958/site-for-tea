<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
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
require("../member/class/user.php");
require("../class/memberfun.php");
if($enews=='AddMemberF')//增加会员字段
{
	AddMemberF($_POST,$logininid,$loginin);
}
elseif($enews=='EditMemberF')//修改会员字段
{
	EditMemberF($_POST,$logininid,$loginin);
}
elseif($enews=='DelMemberF')//删除会员字段
{
	DelMemberF($_GET,$logininid,$loginin);
}
elseif($enews=='EditMemberFOrder')//修改会员字段顺序
{
	EditMemberFOrder($_POST['fid'],$_POST['myorder'],$logininid,$loginin);
}
elseif($enews=='AddMemberForm')//增加会员表单
{
	AddMemberForm($_POST,$logininid,$loginin);
}
elseif($enews=='EditMemberForm')//修改会员表单
{
	EditMemberForm($_POST,$logininid,$loginin);
}
elseif($enews=='DelMemberForm')//删除会员表单
{
	DelMemberForm($_GET,$logininid,$loginin);
}
elseif($enews=="AddMemberGroup")//增加会员组
{
	$add=$_POST;
	AddMemberGroup($add,$logininid,$loginin);
}
elseif($enews=="EditMemberGroup")//修改会员组
{
	$add=$_POST;
	EditMemberGroup($add,$logininid,$loginin);
}
elseif($enews=="DelMemberGroup")//删除会员组
{
	$groupid=$_GET['groupid'];
	DelMemberGroup($groupid,$logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$empire=null;
?>