<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
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
require("class/hShopSysFun.php");

if($enews=="SetShopSys")//商城参数设置
{
	ShopSys_set($_POST,$logininid,$loginin);
}
elseif($enews=="DdRetext")//后台订单备注
{
	ShopSys_DdRetext($_POST,$logininid,$loginin);
}
elseif($enews=='EditPretotal')//修改订单优惠价格
{
	ShopSys_EditPretotal($_POST,$logininid,$loginin);
}
elseif($enews=='DoCutMaxnum')//减少或还原库存
{
	Shopsys_DoCutMaxnum($_POST,$logininid,$loginin);
}
else
{printerror("ErrorUrl","history.go(-1)");}
db_close();
$empire=null;
?>