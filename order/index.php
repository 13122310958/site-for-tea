<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Shanghai');
require_once dirname(__FILE__).'/ordersend.php';
$allow_sep = 0;
if(empty($_POST['dgname'])||empty($_POST['mob'])||empty($_POST['usercode'])||$_POST['usercode'] != $_SESSION['wfcode']){
    echo "<p style='font-size:12px;color:#BD0000;'>错误：验证码不正确！<a href='javascript:history.go(-1);'>返回重新填写 >></a></p>";
    exit(0);
}

if (isset($_SESSION["post_sep"])){
    if (time() - $_SESSION["post_sep"] < $allow_sep){
		$sepmsg = json_encode(iconv('gb2312','utf-8','请勿频繁提交订单！请稍后再试!'));
	    exit("<script>alert($sepmsg);javascript:history.go(-1);</script>");
	}
	else{
	    $_SESSION["post_sep"] = time();
	} 
} 
else{
    $_SESSION["post_sep"] = time(); 
}
extract($_REQUEST);
$refererurl = $_COOKIE["WFLLURL"];
if(empty($refererurl)){
	$refererurl = $_SERVER['HTTP_REFERER'];
}
if(empty($price)){
	$price = explode('|',$product);
	$price = $price[1];
}
$out_trade_no = 'qxc-'.date('YmdHis');
$data = array(
'order_no'=>$out_trade_no, //订单号
'pname'=>'曲线茶',		//产品名称
'url'=>$refererurl,//订单提交页面
'money'=>$price,//订单金额
'clientName'=>$dgname,
'productname'=>$product,
'address'=>$province.$city.$area.$address,
'mobile'=>$mob,
'uid'=>$userid,
'paytype'=>$paytype,
'note'=>$guest);
$cl = new put_client("中");
$data = $cl->build_data($data);
$posturl = $cl->posturl;
$callback = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$i = strrpos($callback,'/');
$callback = substr($callback,0,$i+1).'callback.php';
$_SESSION['data'] = $cl->parse_data($data);
$_SESSION['data']['f_mobile'] = $f_mobile;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>订单正在提交</title>
<style>
html,body{height:100%; overflow:hidden;}
h1{color:#444}
</style>
</head>

<body>
<h1>订单正在提交，请稍等片刻...</h1>
<form action="<?php echo $posturl;?>" method="post">
	<input type="hidden" name="callback" value="<?php echo $callback;?>" >
    <input type="hidden" name="data" value="<?php echo $data;?>" >
</form>
<script>
document.getElementsByTagName('form')[0].submit();
</script>
</body>
</html>
