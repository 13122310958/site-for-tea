<?php
error_reporting(0);
session_start();
if($_GET['result'] != 1){
	echo "<p style='margin:15px; font-size:16px;color:#BD0000;'>对不起订购失败！请联系客服或者稍后再试！<a href='javascript:history.go(-1);'>返回重新填写 >></a></p>";
	exit;
}
$data = $_SESSION['data'];
extract($data);
$tbwidth = $f_mobile ? '100%' : '40%';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if($f_mobile){
echo '<meta name="viewport" content="width=320, minimum-scale=1, maximum-scale=2,user-scalable=no">';
}
?>
<title>WFPHPORDER_wfok</title>
<style type="text/css">
<!--
*{margin:0;padding:0;}
body{font:14px "宋体",Arial,Verdana;color:#333;text-align:left;padding-top:100px;background-color:#fff;} 
a:link,a:visited{color:#F00;text-decoration:none;}a:hover{color:#090;text-decoration:underline;}
#ddok{width:100%;height:auto;overflow:hidden;margin:0 auto;padding:20px 0;background-color:#FFF;}
#ddok table td{padding:10px 20px;}
#ddok table td.tda{text-align:right;background-color:#F7F7F7;}
#ddok table td.tdb{color:#bd0a01;}
.dgok{height:35px;text-align:center;margin-top:20px;font-size:22px;font-weight:bold;color:#090;}
.dgok img{border:0 none;vertical-align:middle;}
-->
</style>
<script type="text/javascript">
function goback(){
	if(window.history.length == 1){
		window.close();
	}else{
		window.history.go(-1);
	}
}
</script>
</head>
<body>
<div id="ddok">
	<table width="<?php echo $tbwidth;?>" border="1" cellpadding="0" cellspacing="0" bordercolordark="#FFFFFF" bordercolorlight="#999999" align="center" style="margin:0 auto;">
	    <tr>
		    <td width="30%" class="tda">订单号</td>
			<td width="70%" class="tdb"><?php echo $order_no; ?></td>
		</tr>
	    <tr>
		    <td width="30%" class="tda">订购产品</td>
			<td width="70%" class="tdb"><?php echo $productname; ?></td>
		</tr>
		<tr>
		    <td class="tda">收货人姓名</td>
			<td class="tdb"><?php echo $clientName; ?></td>
		</tr>
		<tr>
		    <td class="tda">收货人手机号码</td>
			<td class="tdb"><?php echo $mobile; ?></td>
		</tr>
		<?php if(!empty($province)){echo "<tr><td class='tda'>所在地区</td><td class='tdb'>".$province.$city.$area."</td></tr>";}?>
		<tr>
		    <td class="tda">收货人详细地址</td>
			<td class="tdb"><?php echo $address; ?></td>
		</tr>
		<tr>
		    <td class="tda">付款方式</td>
			<td class="tdb"><?php echo $paytype; ?></td>
		</tr>
	</table>
	<div class="dgok"><img src="images/ok.jpg" />　恭喜您，订购成功！</div>
    <div class="dgok"><a href='javascript:goback();'>立即返回 &gt;&gt;</a></div>
</div>
<!-------------------------- 此处添加统计转化代码 -------------------------->

<!-------------------------- 此处添加统计转化代码 -------------------------->
</body>
</html>