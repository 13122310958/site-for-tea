<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../data/dbcache/class.php");
require("../member/class/user.php");
require("../data/dbcache/MemberLevel.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
$enews=$_POST['enews'];
if(empty($enews))
{
	$enews=$_GET['enews'];
}
//导入文件
eCheckCloseMods('shop');//关闭模块
include('class/ShopSysFun.php');

if($enews=="ClearBuycar")//清空购物车
{
	ClearBuycar();
}
elseif($enews=="AddBuycar")//加入购物车
{
	$classid=$_GET['classid'];
	$id=$_GET['id'];
	$pn=$_GET['pn'];
	AddBuycar($classid,$id,$pn,$_GET);
}
elseif($enews=="EditBuycar")//修改购物车
{
	EditBuycar($_POST);
}
elseif($enews=="AddDd")//增加定单
{
	AddDd($_POST);
}
elseif($enews=="ShopDdToPay")//未付款的继续支付
{
	$ddid=$_GET['ddid'];
	ShopDdToPay($ddid);
}
elseif($enews=='DelDd')//取消订单
{
	ShopSys_qDelDd($_GET);
}
elseif($enews=="AddAddress")//新增地址
{
	ShopSys_AddAddress($_POST);
}
elseif($enews=="EditAddress")//修改地址
{
	ShopSys_EditAddress($_POST);
}
elseif($enews=="DelAddress")//删除地址
{
	ShopSys_DelAddress($_GET);
}
elseif($enews=="DefAddress")//默认地址
{
	ShopSys_DefAddress($_GET);
}
else
{printerror("ErrorUrl","history.go(-1)",1);}
db_close();
$empire=null;
?>
