<?php
require('../class/connect.php');
require('../class/db_sql.php');
require('class/user.php');
require('../data/dbcache/MemberLevel.php');
require LoadLang('pub/fun.php');
$link=db_connect();
$empire=new mysqlquery();
$enews=$_POST['enews'];
if(empty($enews))
{
	$enews=$_GET['enews'];
}
eCheckCloseMods('member');//关闭模块
//绑定帐号
$tobind=(int)$_POST['tobind'];
if($tobind&&($enews=='login'||$enews=='register'))
{
	eCheckCloseMods('mconnect');//关闭模块
	eCheckCloseMemberConnect();//验证开启的接口
	session_start();
	include('../memberconnect/memberconnectfun.php');
}
if($enews=='login'||$enews=='exit')
{
	include('class/member_loginfun.php');
}
elseif($enews=='register')
{
	include('class/member_registerfun.php');
	include('class/member_modfun.php');
}
elseif($enews=='EditSafeInfo'||$enews=='EditInfo')
{
	include('class/member_editinfofun.php');
	include('class/member_modfun.php');
}
elseif($enews=='AddFava'||$enews=='DelFava_All'||$enews=='DelFava'||$enews=='AddFavaClass'||$enews=='EditFavaClass'||$enews=='DelFavaClass'||$enews=='MoveFava_All')
{
	include('../data/dbcache/class.php');
	include('class/favfun.php');
}
elseif($enews=='AddMsg'||$enews=='DelMsg'||$enews=='DelMsg_all')
{
	include('class/msgfun.php');
}
elseif($enews=='AddFriend'||$enews=='EditFriend'||$enews=='DelFriend'||$enews=='AddFriendClass'||$enews=='EditFriendClass'||$enews=='DelFriendClass')
{
	include('class/friendfun.php');
}
elseif($enews=='CardGetFen')
{
	include('class/membercomfun.php');
}
elseif($enews=='SendPassword'||$enews=='DoGetPassword'||$enews=='DoActUser'||$enews=='RegSend')
{
	include('class/member_actfun.php');
}

if($enews=="login")//登陆
{
	qlogin($_POST);
}
elseif($enews=="exit")//退出登陆
{
	qloginout($myuserid,$myusername,$myrnd);
}
elseif($enews=="register")//注册
{
	register($_POST);
}
elseif($enews=="EditSafeInfo")//修改安全信息
{
	EditSafeInfo($_POST);
}
elseif($enews=="EditInfo")//修改信息
{
	EditInfo($_POST);
}
elseif($enews=="AddFava")//增加收藏
{
	$cid=$_POST['cid'];
	$id=$_POST['id'];
	$classid=$_POST['classid'];
	$from=$_POST['from'];
	AddFava($id,$classid,$cid,$from);
}
elseif($enews=="DelFava_All")//删除收藏
{
	$favaid=$_POST['favaid'];
	DelFava_All($favaid);
}
elseif($enews=="DelFava")//删除收藏
{
	$favaid=$_GET['favaid'];
	DelFava($favaid);
}
elseif($enews=="CardGetFen")//点卡冲值
{
	$username=$_POST['username'];
	$reusername=$_POST['reusername'];
	$card_no=$_POST['card_no'];
	$password=$_POST['password'];
	CardGetFen($username,$reusername,$card_no,$password);
}
elseif($enews=="AddFavaClass")//增加收藏夹分类
{
	AddFavaClass($_POST);
}
elseif($enews=="EditFavaClass")//修改收藏夹分类
{
	EditFavaClass($_POST);
}
elseif($enews=="DelFavaClass")//删除收藏夹分类
{
	$cid=$_GET['cid'];
	DelFavaClass($cid);
}
elseif($enews=="MoveFava_All")//移动收藏夹
{
	$favaid=$_POST['favaid'];
	$cid=$_POST['cid'];
	MoveFava_All($favaid,$cid);
}
elseif($enews=="AddMsg")//发送短消息
{
	AddMsg($_POST);
}
elseif($enews=="DelMsg")//删除短消息
{
	DelMsg($_GET['mid']);
}
elseif($enews=="DelMsg_all")//批量删除短消息
{
	DelMsg_all($_POST['mid']);
}
elseif($enews=="AddFriend")//添加好友
{
	AddFriend($_POST);
}
elseif($enews=="EditFriend")//修改好友
{
	EditFriend($_POST);
}
elseif($enews=="DelFriend")//删除好友
{
	DelFriend($_GET);
}
elseif($enews=="AddFriendClass")//添加好友分类
{
	AddFriendClass($_POST);
}
elseif($enews=="EditFriendClass")//修改好友分类
{
	EditFriendClass($_POST);
}
elseif($enews=="DelFriendClass")//删除好友分类
{
	DelFriendClass($_GET['cid']);
}
elseif($enews=='SendPassword')//发送取回密码邮件
{
	SendGetPasswordEmail($_POST);
}
elseif($enews=='DoGetPassword')//重设密码
{
	DoGetPassword($_POST);
}
elseif($enews=='DoActUser')//激活帐号
{
	DoActUser($_GET);
}
elseif($enews=='RegSend')//重发激活邮件
{
	DoRegSend($_POST);
}
else
{printerror("ErrorUrl","history.go(-1)",1);}
db_close();
$empire=null;
?>
